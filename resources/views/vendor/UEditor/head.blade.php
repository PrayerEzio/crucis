<script src="{!!asset('/laravel-u-editor/ueditor.config.js',config('crucis.http_secure'))!!}"></script>
<script src="{!!asset('/laravel-u-editor/ueditor.all.min.js',config('crucis.http_secure'))!!}"></script>
{{-- 载入语言文件,根据laravel的语言设置自动载入 --}}
<script src="{!!asset($UeditorLangFile)!!}"></script>