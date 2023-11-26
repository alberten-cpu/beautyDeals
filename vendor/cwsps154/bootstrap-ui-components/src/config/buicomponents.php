<?php
/**
 * PHP Version 8.*
 * Laravel Framework 9.* - 10.*
 *
 * @category configuration
 *
 * @author CWSPS154 <codewithsps154@gmail.com>
 * @license MIT License https://opensource.org/licenses/MIT
 *
 * @link https://github.com/CWSPS154
 *
 * Date 08/10/22
 * */

return [
    'package' => 'bootstrap-ui-components',
    'error' => true,
    'error-class' => 'invalid-feedback',
    'select2' => [
        'enable' => true,
        'custom-css' => true,
        'css' => [
            'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css',
            'https://cdnjs.cloudflare.com/ajax/libs/select2-bootstrap-theme/0.1.0-beta.10/select2-bootstrap.min.css',
        ],
        'js' => ['https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js'],
    ],
    'file-input' => [
        'enable' => true,
        'css' => [
            'https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css',
            'https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.min.css',
            'https://cdn.jsdelivr.net/gh/kartik-v/bootstrap-fileinput@5.5.2/css/fileinput.min.css',
        ],
        'js' => [
            'https://cdn.jsdelivr.net/gh/kartik-v/bootstrap-fileinput@5.5.2/js/plugins/buffer.min.js',
            'https://cdn.jsdelivr.net/gh/kartik-v/bootstrap-fileinput@5.5.2/js/plugins/filetype.min.js',
            'https://cdn.jsdelivr.net/gh/kartik-v/bootstrap-fileinput@5.5.2/js/plugins/piexif.min.js',
            'https://cdn.jsdelivr.net/gh/kartik-v/bootstrap-fileinput@5.5.2/js/plugins/sortable.min.js',
            'https://cdn.jsdelivr.net/gh/kartik-v/bootstrap-fileinput@5.5.2/js/fileinput.min.js',
        ],
    ],
    'cropper' => [
        'enable' => true,
        'theme' => 'bootstrap', // bootstrap or overlay
        'default_image' => '/vendor/bootstrap-ui-components/default-image.png',
        'css' => [
            'https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.css',
        ],
        'js' => [
            'https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js',
        ],
    ],
    'tinymce' => [
        'enable' => true,
        'js' => [
            'https://cdn.tiny.cloud/1/'.env('TINYMCE_KEY').'/tinymce/6/tinymce.min.js',
        ],
        'css' => [],
        'plugins' => 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount checklist mediaembed casechange export formatpainter pageembed linkchecker a11ychecker tinymcespellchecker permanentpen powerpaste advtable advcode editimage tableofcontents footnotes mergetags autocorrect typography inlinecss',
        'toolbar' => 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table mergetags | addcomment showcomments | spellcheckdialog a11ycheck typography | align lineheight | checklist numlist bullist indent outdent | emoticons charmap | removeformat',
        'other-options' => '',
    ],
    'ckeditor' => [
        'enable' => true,
        'js' => [
            'https://cdn.ckeditor.com/ckeditor5/37.0.1/classic/ckeditor.js',
        ],
        'css' => [],
        'other-options' => '',
    ],
    'summernote' => [
        'enable' => true,
        'js' => [
            'https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js',
        ],
        'css' => [
            'https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css',
        ],
        'other-options' => '',
    ],
];
