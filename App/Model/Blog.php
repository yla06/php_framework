<?php
namespace App\Model;

class Blog extends \Model\ModelAbstract
{
    protected $_table     = 'blog';
    protected $_pk        = 'id';
    protected $_relations;
    protected $_rules     = [
        'id'    => [ 'blog_id',    'id',   'ID' ],
        'title' => [ 'blog_title', 'text', 'Заголовок', ['maxlength' => 100] ],
        'text'  => [ 'blog_text',  'textarea', 'Текст блога' ],
    ];
    
}

