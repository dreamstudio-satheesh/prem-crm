<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $guarded = ['customer_id'];

    protected $primaryKey = 'customer_id';

   /*  protected $fillable = [
        'customer_name',
        'primary_contact_id',
        'email_id',
        'company_name',
        'tally_no',
        'tally_version',
        'city',
        'address',
        'lat',
        'lng',
        'whatsapp_telegram_group',
    ]; */

    public function primaryContact()
    {
        return $this->belongsTo(Contact::class, 'primary_contact_id', 'contact_id');
    }

    public function contacts()
    {
        return $this->belongsToMany(Contact::class, 'customer_contacts', 'customer_id', 'contact_id');
    }
}
