@component('mail::message')
# Registration
@component('mail::table')
| Field          | Value                          |
|----------------|--------------------------------|
| **Name**       | {{ @$user->name }}             |
| **Email**      | {{ @$user->email }}            |
| **Phone**      | {{ @$user->mobile }}           |
| **Profession** | {{ @$user->profession }}       |
| **City**       | {{ @$user->city->name }}       |
| **State**      | {{ @$user->state->name }}      |
| **Country**    | {{ @$user->country->name }}    |
| **Zipcode**    | {{ @$user->zipcode }}          |
| **Address**    | {{ @$user->address}}           |

@endcomponent

Thanks and Regards,  
**{{ config('app.name') }}**

@endcomponent
