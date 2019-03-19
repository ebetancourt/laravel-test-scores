<?php
$valuePercent = round($value * 100 / $scale);

$class='';
// if($value == $scale) {
//     $class = $class." complete";
// }

$barclass='';
if ($practice == true) {
    $barclass = "practice";
}
?>

<div class="progress {{ $class }}">
    <div class="progress-bar {{ $barclass }}" style="width:{{ $valuePercent }}%">
        <div class="progress-value">{{ $value }}</div>
    </div>
    <div class="progressbar-title">{{ $scale }}</div>        
</div>
