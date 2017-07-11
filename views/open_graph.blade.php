
<!DOCTYPE html>
<html prefix="og: http://ogp.me/ns#" lang="zh-TW">
<head>
    <meta property="og:title" content="{{ $og->getTitle() }}" />
    <meta property="og:type" content="{{ $og->getType() }}" />
    <meta property="og:image" content="{{ $og->getImage() }}" />
    <meta property="og:url" content="{{ $og->getUrl() }}" />
    <!-- Custom Property -->
    @foreach ($og->getMetadatas() as $key => $content)
        <meta property="{{ $key }}" content="{{ $content }}" />
    @endforeach
    <!-- End Custom Property -->
</head>
</html>