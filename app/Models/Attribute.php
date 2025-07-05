<?php

namespace App\Models;

use App\Models\Product;
use App\Models\AttributeValue;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\App; // استدعاء مهم
use Illuminate\Validation\ValidationException;

class Attribute extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'name_fr', 'is_locked'];
    protected static function booted()
    {
        static::updating(function ($attribute) {
            // تحقق إذا كانت الخاصية محمية وحاول أحدهم تغيير اسمها الأساسي (العربي)
            if ($attribute->getOriginal('is_locked') && $attribute->isDirty('name')) {
                throw ValidationException::withMessages([
                    'name' => 'لا يمكن تعديل اسم خاصية محمية من النظام.'
                ]);
            }
        });

        static::deleting(function ($attribute) {
            if ($attribute->is_locked) {
                throw ValidationException::withMessages([
                    'error' => 'لا يمكن حذف خاصية محمية من النظام.'
                ]);
            }
        });
    }

    /**
     * Accessor لجلب الاسم حسب لغة التطبيق الحالية.
     * يمكنك استخدامه في الواجهة هكذا: $attribute->localized_name
     */
    public function getLocalizedNameAttribute()
    {
        $locale = App::getLocale();
        if ($locale === 'fr' && !empty($this->name_fr)) {
            return $this->name_fr;
        }
        return $this->name;
    }

    public function values()
    {
        return $this->hasMany(AttributeValue::class);
    }
    public function products()
{
    return $this->belongsToMany(Product::class);
}

}

