<?php session_start();
	if (!isset($_SESSION["user_name"])) {
		header("Location: /index.php");
	}
 	require_once(ROOT_PATH."Jpgraph/jpgraph.php");
 	require_once(ROOT_PATH."Jpgraph/jpgraph_bar.php");
 	require_once(ROOT_PATH."Controllers/TotalIntakesController.php");
 	function con($arg){
 		if (strtoupper(substr(PHP_OS, 0, 3))!=="WIN") {
 			return(mb_convert_encoding($arg, 'SJIS'));
 		}else{
 			return($arg);
 		}
 	}
 	$total_intake = new TotalIntakesController();
 	$total_intakes = $total_intake->index();
 	// 縦軸のデータ
 	$data = [];
 	foreach ($total_intakes as $intake) {
 		$data[] = (int)$intake["calorie"];
 	}
 	// 取得7件未満で補填する
 	if (count($data)!==7) {
 		for ($i=0; $i < 7-count($total_intakes) ; $i++) { 
 			$data[] = 0;
 		}
 	}
 	// インデックス降順でソート
 	$result = [];
 	for ($i=6; $i >= 0 ; $i--) { 
 		$result[]= $data[$i];
 	}
	$x_data = $result;

	// グラフの生成
	$graph = new Graph(400, 300, "auto");
	// $graph->SetFrame(true);
	$graph->SetShadow();
	$graph->SetScale('textlin');
	$graph->img->SetMargin(40,30,20,40);
	$graph->SetMarginColor('silver');

	// タイトル

	// y軸
	$graph->yaxis->title->Set("kcal");
	// x軸
	$count = 0;
	for ($i=-6; $i <= $count ; $i++) { 
		$date[] = date("m-d",strtotime("${i}day"));
	}

	$graph->xaxis->SetTickLabels($date);

	// グラフ表示
	$bar = new BarPlot($x_data);
	$bar->value->Show();
	// $bar->value->SetFormat('%d');
	// $bar->SetValuePos("center");
	// $graph->yaxis->scale->SetGrace(20);
	$graph->Add($bar);
	$graph->Stroke();

?>