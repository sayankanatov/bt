RewriteEngine On

RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule ^(.*)/$ /$1 [L,R=301]

RewriteCond %{REQUEST_URI} !(\.css|\.js|\.png|\.jpg|\.gif|robots\.txt)$ [NC]
RewriteCond %{REQUEST_FILENAME} !-d
RewriteCond %{REQUEST_FILENAME} !-f
RewriteRule ^ index.php [L]

RewriteCond %{REQUEST_FILENAME} !-d
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_URI} !^/public/
RewriteRule ^(css|js|images)/(.*)$ public/$1/$2 [L,NC]


@if($kindergarten->group_count - $groups->count() > 0)
  <div class="alert alert-warning">
    <p>@lang('messages.you_must_add') {{$kindergarten->group_count - $groups->count()}} @lang('messages.group')</p>
  </div>
  @elseif($groups->count() - $kindergarten->group_count > 0)
  <div class="alert alert-warning">
    <p>@lang('messages.you_must_edit_general_info') {{$groups->count() - $kindergarten->group_count}} @lang('messages.group')</p>
  </div>
  @endif
