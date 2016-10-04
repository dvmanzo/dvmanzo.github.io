<?php // content="text/plain; charset=utf-8"
require_once ('jpgraph/jpgraph.php');
require_once ('jpgraph/jpgraph_scatter.php');
 
// Each ballon is specificed by four values. 
// (X,Y,Size,Color)
 
$data=array();
$handle = fopen("cars-sample.csv", "r");
while (($dataset = fgetcsv($handle, 1000, ",")) !== FALSE)
{
	if($i==0)
	{
		$i++;
	}
	else
	{
		$temparray=array(floatval($dataset[7])/10,$dataset[3],floatval($dataset[7])/1000,$dataset[2]);
		$data[$i]=$temparray;
		$i++;
	}
}
fclose($handle);
 
 
// We need to create X,Y data vectors suitable for the
// library from the above raw data.
$n = count($data);
for( $i=0; $i < $n; ++$i ) {
    
    $datax[$i] = floatval($data[$i][0]);
    $datay[$i] = floatval($data[$i][1]);
 
    // Create a faster lookup array so we don't have to search
    // for the correct values in the callback function
    $format[strval($datax[$i])][strval($datay[$i])] = array(floatval($data[$i][2]),$data[$i][3]);
    
}
 
 
// Callback for markers
// Must return array(width,border_color,fill_color,filename,imgscale)
// If any of the returned values are '' then the
// default value for that parameter will be used (possible empty)
function FCallback($aYVal,$aXVal) {
    global $format;
    return array($format[strval($aXVal)][strval($aYVal)][0],'',
         $format[strval($aXVal)][strval($aYVal)][1],'','');
}
 
// Setup a basic graph
$graph = new Graph(700,700,'auto');
$graph->SetScale("intlin");
$graph->SetMargin(40,40,40,40);        
$graph->SetMarginColor('wheat');
 
$graph->title->Set("PHP Implementation");
$graph->title->SetMargin(10);
 
// Use a lot of grace to get large scales since the ballon have
// size and we don't want them to collide with the X-axis
$graph->yaxis->scale->SetGrace(0,0);
$graph->xaxis->scale->SetGrace(0,0);
 
// Make sure X-axis as at the bottom of the graph and not at the default Y=0
$graph->xaxis->SetPos('min');
 
// Set X-scale to start at 0
$graph->xscale->SetAutoMin(200);
$graph->xscale->SetAutoMax(500);
$graph->yscale->SetAutoMin(10);
$graph->yscale->SetAutoMax(40);
$graph->xaxis->scale->ticks->Set(10,5); 
$graph->yaxis->scale->ticks->Set(10,5); 
// Create the scatter plot
$sp1 = new ScatterPlot($datay,$datax);
$sp1->mark->SetType(MARK_FILLEDCIRCLE);
 
// Uncomment the following two lines to display the values
//$sp1->value->Show();
 
// Specify the callback
$sp1->mark->SetCallbackYX("FCallback");
 
// Add the scatter plot to the graph
$graph->Add($sp1);
 
// ... and send to browser
$graph->Stroke();
?>