<?php

namespace App\Traits;
use App\Models\{
    ReportUser,
    Product,
    Subcategory,
    OrderLog,
    Payment
};
use DB;
use Illuminate\Http\Request;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Intervention\Image\Facades\Image;

trait DefaultTrait
{
    public function verifyAndUpload(Request $request, $fieldname, $directory) {

        if( $request->hasFile( $fieldname ) ) {

            if (!$request->file($fieldname)->isValid()) {
                return null;
            }
            $attachment = $request->file($fieldname);
            $randomName = str()->random(30);
            $name = $attachment->getClientOriginalName();
            $fileName = str($name)->append($randomName)->slug().'.'.$attachment->getClientOriginalExtension();
            $directoryPath = public_path($directory);
            if (!file_exists($directoryPath)) {
                mkdir($directoryPath, 0755, true);
            }
            $request->file($fieldname)->move($directoryPath, $fileName);
            $filePath = $directory.$fileName;
            return $filePath;
        }

        return null;

    }

    public function ImageResizer(Request $request, $fieldname, $directory, $size_height, $size_width) {
        if( $request->hasFile( $fieldname ) ) {

            if (!$request->file($fieldname)->isValid()) {
                return null;
            }
            
            $thumbnail = $request->file($fieldname);
            $originalName = pathinfo($thumbnail->getClientOriginalName(), PATHINFO_FILENAME);
            $extension = strtolower($thumbnail->getClientOriginalExtension());
            $fileName = time().'-'.str($originalName)->slug().'.'.$extension;

            $directoryPath = public_path($directory);
            if (!file_exists($directoryPath)) {
                mkdir($directoryPath, 0755, true);
            }

            $thumbnail->move($directoryPath, $fileName);
            $absoluteFilePath = $directoryPath . DIRECTORY_SEPARATOR . $fileName;

            if (in_array($extension, ['svg', 'gif'], true)) {
                return $directory.$fileName;
            }

            $imgManager = new ImageManager(new Driver());
            $thumbImage = $imgManager->read($absoluteFilePath);
            $thumbImage->resize($size_height, $size_width);
            $thumbImage->save($absoluteFilePath);

            return $directory.$fileName;
        }
        return null;
    }

    public function handleUpload(Request $request, $fieldname, $directory, $isImage = false, $resizeWidth = null, $resizeHeight = null)
    {
        if ($request->hasFile($fieldname)) {
    
            $file = $request->file($fieldname);
    
            // Validate the uploaded file
            if (!$file->isValid()) {
                return back()->with('error', 'Invalid file!');
            }
    
            // Generate a unique filename
            $fileName = $file->getClientOriginalName();
            $fileName = \Str::slug(pathinfo($fileName, PATHINFO_FILENAME)) . '.' . $file->getClientOriginalExtension();
    
            // Ensure directory exists
            $directoryPath = public_path($directory);
            if (!file_exists($directoryPath)) {
                mkdir($directoryPath, 0777, true);
            }
    
            // Handle image resizing (if the file is an image)
            if ($isImage) {
                $filePath = $directory . '/' . $fileName;
                Image::make($file)
                    ->resize($resizeWidth, $resizeHeight, function ($constraint) {
                        $constraint->aspectRatio(); // Maintain aspect ratio
                        $constraint->upsize(); // Prevent stretching
                    })
                    ->save(public_path($filePath));
            } else {
                // Move the file to the specified directory (for PDFs or non-images)
                $filePath = $directory . '/' . $fileName;
                $file->move($directoryPath, $fileName);
            }
    
            // Return the relative path of the uploaded file
            return $filePath;
        }
    
        return null; // Return null if no file was uploaded
    }

    public function generateQrCode($filePath, $qrCodeDirectory)
    {
        // Ensure the QR code directory exists
        $qrCodePath = public_path($qrCodeDirectory);
        if (!file_exists($qrCodePath)) {
            mkdir($qrCodePath, 0777, true);
        }
    
        // Generate the QR code for the file URL
        $fileUrl = asset($filePath); // Create a public URL for the file
        $qrCodeFileName = uniqid() . '.png';
        $qrCodeFullPath = $qrCodeDirectory . '/' . $qrCodeFileName;
    
        QrCode::format('png')
            ->size(200)
            ->generate($fileUrl, public_path($qrCodeFullPath));
    
        return $qrCodeFullPath; // Return the relative path of the QR code
    }

    public function employees(){
        return User::where(['user_type'=>'Employee'])->get();
    }

    public function assigningReportUsers($reportingIds, $userId, $userType){
        DB::table('report_users')->where('user_id',$userId)->delete();
        foreach ($reportingIds as $key => $value) {
            ReportUser::updateOrCreate(
                [
                    'reporting_id' => $value,
                    'user_id' => $userId,
                ],
                [
                    'reporting_id' => $value,
                    'user_id' => $userId,
                    'title' => $userType,
                ]
            );
        }  
    }

    public function productStockStatus($poroductId){
        $product = Product::whereId($poroductId)->first();
        if($product->productAttribute->stock_pcs>0){
            $status = "Active";
        }else{
            $status = 'Out-of-Stock';
        }
        return Product::whereId($poroductId)->update(['status'=>$status]);
    }

    public function productsStatusUpdateSubCategory($subcategoryId){
        $subCategory = Subcategory::whereId($subcategoryId)->first();
        if(!$subCategory || $subCategory->products->count() === 0){
            return;
        }

        return Product::where(['subcategory_id'=>$subcategoryId])->update([
            'is_visible_website' => $subCategory->is_visible_website,
            'status' => $subCategory->status,
        ]);
    }

    public function updateProductUrl($productId){
        $product = Product::whereId($productId)->first();
        if(!empty($product)){
            $url_key = str($product->name)->append('-'.$product->sku_code)->slug();
            return Product::whereId($productId)->update(['url_key'=>$url_key]);
        }
    }

    public function create_order_log_status($order_id, $status){
        return OrderLog::updateOrCreate(
            [
                'order_id' => $order_id,
                'change_value' => "Pending",
            ],
            [
                'order_id' => $order_id,
                'user_id' => auth()->user()->id,
                'user_name' => auth()->user()->name,
                'change_value' => $status,
                'change_type' => 'status',
            ],
        );
    }

    public function sendError($error, $errorMessages = [], $code = 200)
    {
        $response = [
            'status'    => 404,
            'success' => false,
            'message' => $error,
        ];
        if(!empty($errorMessages)){
            $response['data'] = $errorMessages;
        }
        return response()->json($response, $code);
    }
}
