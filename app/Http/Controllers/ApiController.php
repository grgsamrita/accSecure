<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Category;
use App\UserEvent;
use App\Zevent;
use App\User;
use App\Occurance;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class ApiController extends Controller {
	
	public function __construct()
	{
		$this->middleware('cors');
	}


	public function getAllevents(Request $request){
		$uid = $request->get('uid');
		$ulat = $request->get('lat');
		$ulong = $request->get('long');

		$start = microtime(true);
		$occurance = Occurance::all();
		$categories = Category::all();
		$events = [];
		$eventcat = [];
		$allcategory = [];

		try{
			foreach ($occurance as $eachoccurance) {
				try{
					$zevent = Zevent::find($eachoccurance->zevent_id);
				}catch(Exception $e){
					
					return ['message' => 'Event Not Valid.'];
				}

				$images = $zevent->images;

				$eachevents = [];
				$cate = [];

				try{
					foreach ($zevent->eventCategories as $eachevcate) {
						array_push($cate, $eachevcate->category->name);
					}
				}catch(Exception $e){

					return ['message' => $e->getMessage()];
				}

				$img = null;
				$thumbImg = null;
				foreach ($images as $eachimage) {
					if($eachimage->is_primary){
						$imgArr = explode('.', $eachimage->url);
						$countimg = count($imgArr);
						$extent = $imgArr[$countimg-1];
						$img = str_replace('.'.$extent, '_lw.'.$extent, $eachimage->url);
						$thumbImg = str_replace('.'.$extent, '_thumb.'.$extent, $eachimage->url);
					}
				}
				

				try{

					$dist = $this->getDistance($ulat, $ulong, $zevent->venue->latitude, $zevent->venue->longitude);

					if($dist > 14){
						continue;
					}

					$userEvent = UserEvent::where('user_id', $uid)->where('zevent_id', $zevent->id)->first();

					$eachevents['going'] = 2;  			// no stat available
					if($userEvent){
						if($userEvent->going == 1){
							$eachevents['going'] = 1;  	//going stat
						}else{
							$eachevents['going'] = 0; 	//not going stat
						}
					}

					$eachevents['id'] = $eachoccurance->zevent_id;
			  		$eachevents['name'] = $zevent->name;
			  		$eachevents['featured'] = $zevent->featured;
			  		$eachevents['organizer'] = $zevent->organizer->name;
			  		$eachevents['venue'] = $zevent->venue->name;
			  		$eachevents['image'] = $img;
			  		$eachevents['thumbImg'] = $thumbImg;
			  		$eachevents['date'] = date('Y-m-d', strtotime($eachoccurance->occurance_datetime));
			  		$eachevents['time'] = date('H:i:s', strtotime($eachoccurance->occurance_datetime));
			  		$eachevents['description'] = $zevent->description;
			  		$eachevents['lng'] = $zevent->venue->longitude;
			  		$eachevents['lat'] = $zevent->venue->latitude;
			  		$eachevents['category'] = $cate;
			  	}catch(Exception $e){

			  		return ['message' => $e->getMessage()];
			  	}

		  		array_push($events, $eachevents);
			}

			usort($events, array($this, "sortFunction"));
		}catch(Exception $e){

			return ['message' => $e->getMessage()];
		}

		try{
			foreach ($categories as $eachcategory) {
				$categoryEvents = [];
				
				foreach ($events as $eachev) {
					if(in_array($eachcategory->name, $eachev['category'])){
						array_push($categoryEvents, $eachev);
					}
				}

				array_push($allcategory, $eachcategory->name);
				if($categoryEvents == array()){
					continue;
				}

				$eachcat['data'] = $categoryEvents;
				$eachcat['name'] = $eachcategory->name;

				array_push($eventcat, $eachcat);
			}
		}catch(Exception $e){

			return ['message' => $e->getMessage()];
		}

		return ['allevents'=>$events, 'eventcategories'=>$eventcat, 'allcategories' => $allcategory, 'time'=>(microtime(true)-$start)];
	}

	function sortFunction( $a, $b ) {
	    return strtotime($a["date"]." ".$a["time"]) - strtotime($b["date"]." ".$b["time"]);
	}


	public function getDistance($latitudeFrom, $longitudeFrom, $latitudeTo, $longitudeTo, $earthRadius = 6371000)
	{
		// $start = microtime(true);
		$i = 0;
	  // convert from degrees to radians
		while ($i < 100) {
			
	  $latFrom = deg2rad($latitudeFrom);
	  $lonFrom = deg2rad($longitudeFrom);
	  $latTo = deg2rad($latitudeTo);
	  $lonTo = deg2rad($longitudeTo);

	  $latDelta = $latTo - $latFrom;
	  $lonDelta = $lonTo - $lonFrom;

	  $angle = 2 * asin(sqrt(pow(sin($latDelta / 2), 2) +
	    cos($latFrom) * cos($latTo) * pow(sin($lonDelta / 2), 2)));
	  $i++;
	}
	  return ($angle * $earthRadius)/1000;
	  // return (microtime(true)-$start);
	}

	

	public function getTokenget(){
		return csrf_token();
	}


	public function postTest(){
		return \Input::all();
	}

	public function getNearestevents(Request $request){
		$input_d = ($request->get('input_distance')=="")?5:$request->get('input_distance');
		$ulat = $request->get('lat');
		$ulong = $request->get('long');
		
		$occurance = Occurance::all();		
		$events = [];		

		try{
			foreach ($occurance as $eachoccurance) {
				try{
					$zevent = Zevent::find($eachoccurance->zevent_id);

				}catch(Exception $e){
					
					return ['message' => 'Event Not Valid.'];
				}

				try{

					$near_dist = $this->getDistance($ulat, $ulong, $zevent->venue->latitude, $zevent->venue->longitude);
					
					// $dist_input = null;
					// if($input_d){
					
					// 	$dist_input = $input_d;
					// }
					// else{
					// 	$dist_input = 5;
					// }
					
					// return $dist_input;
					if($near_dist > $input_d){
						continue;
					}
					
					array_push($events, $zevent->name);		
					
				
			  	}catch(Exception $e){

			  		return ['message' => $e->getMessage()];
			  	}
		  		
			}
			return ['allevents'=>$events];
		}catch(Exception $e){

			return ['message' => $e->getMessage()];
		}	
	}	

}
?>
