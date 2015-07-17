<div class="list-group">
<?
$max = $min = 0;
$maxsize = 40;
$minsize = 5;
foreach ($this->tags as $tag) {
    $c = $tag['count'];
    if ($c > $max) $max = $c;
    if ($c < $min) $min = $c;
}
$step = ($maxsize - $minsize) / ($max - $min);
foreach ($tags as $tag) {
    $size = round($minsize + ($tag['count'] - $minval) * $step)?>
        <a href="tags/view/<?=$tag['tag_id']?>" style="font-size:<?=$size?>px"><?=$tag['tag_name']?></a>
<? } ?>
    </div>