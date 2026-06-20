@component('mail::message')
# Contact Inquiry

@component('mail::table')
| Field          | Value                          |
|----------------|--------------------------------|
| **Name**       | {{ @$data['name'] }}           |
| **Company Name**    | {{ @$data['company_name'] }}   |
| **Email**      | {{ @$data['email'] }}          |
| **Phone**      | {{ @$data['mobile'] }}         |
| **Enquiry Type**       | {{ @$data['enquiry_type'] }}   |
| **City**       | {{ @$data->city->name }}       |
| **State**      | {{ @$data->state->name }}      |
| **Country**    | {{ @$data->country->name }}    |
| **Zipcode**    | {{ @$data->pincode->code }}    |
| **Address**    | {{ @$data['address'] }}        |
| **Message**    | {{ @$data['purpose'] }}        |
| **IP Address** | {{ @$data['ip_address'] }}     |
@endcomponent

Thanks and Regards,  
**{{ config('app.name') }}**

@endcomponent
