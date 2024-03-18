<?php
include_once "layout/header.php";
require_once "layout/common.php";
?>

<?php
$value = $_GET["post"];
$content = file_get_contents($value);
if ($content === false) {
    die("Failed to read " . $value);
}

$parser = new FrontmatterParser($content);
$metadata = $parser->GetMetadata();

?>

<h1><?= $metadata["title"] ?></h1>

<p class="blog-date">
    <?php
    date_default_timezone_set('UTC');
    $date = new DateTimeImmutable($metadata["date"]);
    echo $date->format('l jS \o\f F Y');
    ?>
</p>

<?php
$Parsedown = new Parsedown();
echo $Parsedown->text($parser->GetMarkdown());

?>

<?php
include_once "layout/footer.php";
?>