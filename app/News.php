<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class News
 * @package App
 *
 * @property string title;
 * @property string image;
 * @property string body;
 * @property boolean isPrivate;
 * @property integer category_id;
 */
class News extends Model
{
    protected $fillable = [
        'title',
        'image',
        'body',
        'isPrivate',
        'category_id'
    ];

    public function category() {
        return $this->belongsTo(Category::class, 'category_id')->first();
    }

    public function getLimit($limit) {
        return $this::query()
            ->select(['id', 'title', 'image', 'created_at'])
            ->limit($limit)
            ->orderBy('created_at', 'DESC')
            ->get();
    }

    public static function rules() {
        $categories = (new Category)->getTable();
        return [
            "title" => "required|min:10|max:100",
            "category_id" => "required|exists:{$categories},id",
            "body" => "required",
            "image" => "mimes:jpeg,bmp,png|max:4000"
        ];
    }

    public static function attributeNames() {
        return [
            'title' => 'Заголовок',
            'category_id' => 'Категория',
            'body' => 'Текст',
            'image' => 'Изображение'
        ];
    }
}

