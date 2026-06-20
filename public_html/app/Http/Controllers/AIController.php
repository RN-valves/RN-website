<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Smalot\PdfParser\Parser;
use App\Models\Faq;
use App\Models\Catalogue;
use App\Models\Product;
use OpenAI\Client;
use App\Services\OpenAIService;
use Spatie\PdfToText\Pdf;
use thiagoalessio\TesseractOCR\TesseractOCR;

class AIController extends Controller
{
    protected $openAIService;

    public function __construct(OpenAIService $openAIService)
    {
        $this->openAIService = $openAIService;
    }

    public function chat(){
    
        return view('users.websites.asistantai');
    }
    public function uploadPDF(Request $request)
    {
        if($request->method() == 'POST'){

     
        // Validate file
        $request->validate([
            'pdf_file' => 'required|mimes:pdf',
        ]);

        if ($request->hasFile('pdf_file')) {
            $file = $request->file('pdf_file');
            $pdfPath = $file->storeAs('uploads', $file->getClientOriginalName());

            $parser = new Parser();
            $pdf = $parser->parseFile(storage_path('app/' . $pdfPath));
            $text = $pdf->getText();

            if (empty(trim($text))) {
                // Convert PDF pages to images (using Imagick)
                $imagesPath = $this->convertPdfToImages(storage_path('app/' . $pdfPath));

                foreach ($imagesPath as $image) {
                    $ocr = new TesseractOCR($image);
                    $text .= $ocr->run() . "\n";
                }
            }

            $txtFileName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME) . '.txt';
            $txtFilePath = storage_path('app/uploads/' . $txtFileName);
            file_put_contents($txtFilePath, $text);

            return back()->with('success', 'Upload Successfully successfully');
        } else {
            return back()->withErrors(['pdf' => 'No file uploaded. Please try again.']);
        }
         
        }
        return view('admin.fronts.pdf-upload');
    
    }
    private function convertPdfToImages($pdfPath)
    {
        $images = [];
        $imagick = new \Imagick();
        $imagick->readImage($pdfPath);

        foreach ($imagick as $index => $image) {
            $image->setResolution(300, 300);
            $image->setImageFormat('jpeg');
            $imagePath = storage_path("app/uploads/page-{$index}.jpg");
            $image->writeImage($imagePath);
            $images[] = $imagePath;
        }

        $imagick->clear();
        $imagick->destroy();

        return $images;
    }

    public function askQuestion(Request $request, $pdf_id)
    {
        $request->validate([
            'question' => 'required|string|max:1000',
        ]);
        $userQuestion = $request->input('question');
        $context = "Hi, welcome to the RN family. We are Brass & PTMT bath fittings manufacturing specialists. In the last 24 years of our existence. We have sold about 84 crores of bath fittings in about 7000+ products and our customers are spread across all of India. Some of our customers are Johnson, Hindware, Cera, Somany etc.
        RN valves and faucets India’s fastest growing modern bathroom Solutions Company, established in 2000 by Mr. Rajeev Jain (managing director).    
        Being a totally Indian brand, RN Valves & Faucets deals with Indian made products with global level technologies.
        The products designed with the Indian fine tradition of Exquisite craftsmanship, precision, and modern technology provide an astonishing experience for young consumers.   
        We have helped over 4800 distributors and dealers to generate more than 1300 crores of revenue in the last 24 years. These days, on average a dealer is generating more than 10 lacs of revenue to sell our products and our dealers earn two to three times of profits against the competition to sell our products.
        The designing of each product is done after the intensified process of research and a substantial level study of water behavior and flowing properties. Our constant efforts on consecutive testing and development in the field of research drive us to create remarkably durable and amazingly eco-friendly products for a better future for the world.
        We, at RN Valves & Faucets, believe in empowering the work environment, and with the introduction of professional mentorship and work ethics, we are able to provide ace quality in products and support services. From seamless delivery to constant work on the needs of new users, RN Valves & faucets deliver an assured quality experience. Our extensive range of high-class products provides a luxury style statement to your dream bathspace.";
       
        $catalogues = Catalogue::where('status', 1)->get();
        foreach ($catalogues as $cata) {
            $name = mb_convert_encoding($cata->name, 'UTF-8', 'auto');
            $pdf = mb_convert_encoding($cata->pdf, 'UTF-8', 'auto');
            $context .= "Q: {$name}\nA: https://rnvalves.com/{$pdf}\n\n";
        }
        
        $faqs = Faq::where('status', 1)->get();
        foreach ($faqs as $faq) {
            $question = mb_convert_encoding($faq->question, 'UTF-8', 'auto');
            $answer = mb_convert_encoding($faq->answer, 'UTF-8', 'auto');
            $context .= "Q: {$question}\nA: {$answer}\n\n";
        }
        // $products = Product::select('name', 'sku_code', 'in_mrp', 'in_v1_mrp', 'size', 'material', 'color_name', 'article')
        // ->where('status', 'Active')
        // ->where('is_visible_website', 1)
        // ->limit(3000)
        // ->get();
        // foreach ($products as $product) {
        //     // Ensure UTF-8 encoding and remove invalid characters
        //     $name = $this->cleanUtf8($product->name);
        //     $sku_code = $this->cleanUtf8($product->sku_code);
        //     $in_mrp = $this->cleanUtf8($product->in_mrp);
        //     $in_v1_mrp = $this->cleanUtf8($product->in_v1_mrp);
        //     $size = $this->cleanUtf8($product->size);
        //     $material = $this->cleanUtf8($product->material);
        //     $color_name = $this->cleanUtf8($product->color_name);
        //     $article = $this->cleanUtf8($product->article);
        
        //     // Build context string
        //     $context .= "Product: {$name}\n";
        //     if ($sku_code) {
        //         $context .= "SKU Code: {$sku_code}\n";
        //     }
        //     if ($in_mrp) {
        //         $context .= "Price: ₹{$in_mrp}\n";
        //     }
        //     if ($in_v1_mrp) {
        //         $context .= "MRP: ₹{$in_v1_mrp}\n";
        //     }
        //     if ($size) {
        //         $context .= "Size: {$size}\n";
        //     }
        //     if ($material) {
        //         $context .= "Material: {$material}\n";
        //     }
        //     if ($color_name) {
        //         $context .= "Color Name: {$color_name}\n";
        //     }
        //     if ($article) {
        //         $context .= "Article: {$article}\n";
        //     }
        //     $context .= "\n";
        // }
        try {
            $response = $this->openAIService->askGPT($context, $userQuestion);
            return response()->json([
                'success' => true,
                'answer' => $response['answer'],
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => 'Failed to generate a response. Please try again later.',
                'details' => $e->getMessage(),
            ], 500);
        }
    }

    private function cleanUtf8($text)
    {
        if ($text === null) {
            return '';
        }

    $text = mb_convert_encoding($text, 'UTF-8', 'UTF-8');
    $text = preg_replace('/[\x00-\x1F\x7F-\x9F]/u', '', $text);

    return $text;
    }

}
