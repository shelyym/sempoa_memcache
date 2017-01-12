<?
$jml = 0;
$total = 0;
$small = 100;
$big = 0;
$t = time();
foreach ($graph as $num => $result) {
    $labels[] = $num + 1;
    $data[] = $result->nilai;
    $total += $result->nilai;
    $jml++;
    if ($small > $result->nilai) {
        $small = $result->nilai;
    }
    if ($big < $result->nilai) {
        $big = $result->nilai;
    }
}

$rata = round($total / $jml, 2);;
$imp = implode(",", $labels);
$impnilai = implode(",", $data);
//    
//    
//         echo "Rata: " . $rata . "<br>";
//         echo "imp: " . $imp . "<br>";
//         echo "impnilai: " . $impnilai . "<br>";
?>
<style type="text/css">
    .nilainya {
        font-size: 13em;
        text-align: center;
        width: 100%;
    }

    .tglnilai, .isinilai {
        float: left;
        width: 50%;
    }

    .isinilai {
        font-weight: bold;
    }

    .rightnilai {
        padding-bottom: 5px;
    }

    .satuannilai {
        clear: both;
        margin: 10px;
        padding: 10px;
        text-align: center;
        background-color: #efefef;
        border-radius: 3px;
    }

    .clear {
        clear: both;
    }
</style>

<div style="float:left; width: 320px; ">

    <div class="nilairata">
        <div class="ratalabel">Avg. Grade</div>
        <div class="nilainya"><?= $rata; ?></div>
    </div>
</div>
<div style="float:left; width: 320px;padding-top: 10px;">
    <canvas id="canvas_<?= $t; ?>" width="320px" height="200px"></canvas>
</div>
<div class="clear"></div>
<div style="float:left; width: 320px;padding-top: 10px;">
    <?
    $rev = array_reverse($graph);
    foreach ($rev as $num => $result) {
        ?>
        <div class="satuannilai">
            <div class="tglnilai">
                <?= date("d-m-Y", strtotime($result->tgl_ujian)); ?>
            </div>
            <div class="isinilai <? if ($result->nilai < 60) {
                echo "redgrade";
            } ?>">
                <?= $result->nilai; ?>
            </div>
            <div class="clear"></div>
        </div>
    <? } ?>
</div>

<div style="float:left; width: 320px;padding-top: 10px; text-align: right;">
    <div class="rightnilai">
        Highest Grade : <b><?= $big; ?></b>
    </div>
    <div class="rightnilai">
        Lowest Grade : <b><?= $small; ?></b>
    </div>
    <div class="rightnilai">
        Total Data : <b><?= $jml; ?></b>
    </div>
    <div class="rightnilai">
        Total Score : <b><?= $total; ?></b>
    </div>
</div>
<div class="clear" style="margin-bottom: 200px;"></div>
<script>
    var lineChartData = {
        labels: [0, <?=$imp;?>],
        datasets: [{
            showScale: true,
            scaleBeginAtZero: true,
            pointHitDetectionRadius: 10,
            fillColor: "rgba(151,187,205,0.5)",
            strokeColor: "rgba(151,187,205,1)",
            pointColor: "rgba(151,187,205,1)",
            pointStrokeColor: "#fff",
            data: [0, <?=$impnilai;?>]
        }
        ]

    };
    var myLine = new Chart(document.getElementById("canvas_<?=$t;?>").getContext("2d")).Line(lineChartData);


</script>
    