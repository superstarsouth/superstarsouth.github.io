<?php
include_once "layout/header.php";
require_once "layout/common.php";
?>

<?php
function getFirstLines($string, $lineCount)
{
    $lines = explode("\n", $string);
    return implode("\n", array_slice($lines, 0, $lineCount));
}

function isMD($var)
{
    return str_ends_with($var, ".md");
}

$files = scandir("posts", SCANDIR_SORT_DESCENDING);
$files = array_filter($files, "isMD");

$posts = array();

foreach ($files as &$value) {
    $content = file_get_contents("posts/" . $value);
    if ($content === false) {
        die("Failed to read " . $value);
        continue;
    }

    $parser = new FrontmatterParser($content);
    $metadata = $parser->GetMetadata();
    $metadata["filename"] = $value;
    $metadata["url"] = "/posts/" . substr($value, 0, -3);
    $metadata["trimmedContent"] = getFirstLines($parser->GetMarkdown(), 3);
    array_push($posts, $metadata);
}
unset($value);
unset($files);
?>

<h1>Devlog</h1>

<?php foreach ($posts as &$post) : ?>

    <div class="blog-post">
        <h2><?= $post["title"] ?></h2>
        <div>
            <?php
            $Parsedown = new Parsedown();
            echo $Parsedown->text($metadata["trimmedContent"]);
            ?>

            <a href="<?= $post["url"] ?>" class="glossy-btn bg-orange">Read more</a>
        </div>
    </div>
<?php
endforeach;
unset($post);
?>

<?php
include_once "layout/footer.php";
?>