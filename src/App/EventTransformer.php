<?php
namespace App;
use App\Event;
use League\Fractal;

class EventTransformer extends Fractal\TransformerAbstract {

    private $params = [];

    function __construct($params = []) {
        $this->params = $params;
        $this->params['value'] = false;
    }




    protected $availableIncludes = [
    'bookmarks',
    ];

    public function transform(Event $event) {
        
            $total_bookmarks = $event->Bookmarked;
        $this->params['total'] = count($total_bookmarks);
        $bookmarks = $event->Bookmarked->where(['student_id' => $this->params['student_id']]);
        if (count($bookmarks) > 0) {
            $this->params['value'] = true;
        } else {
            $this->params['value'] = false;
        }
        return [
        "id" => (integer) $event->event_id ?: 0,
        "title" => (string) $event->title ?: null,
        "subtitle" => (string) $event->subtitle ?: null,
        "details"=> [
            "venue" => (string) $event->venue ?: null,
            "type" => $event->Type['name']?:null,
            "team" => (integer) $event->price ?: 0,
            "price" => (integer) $event->price ?: 0,
            "description" => (string) $event->description ?: null,
            "rules" => (string) $event->description ?: null,
            ],
        "contact" => [
            [
                "name" => (string) $event->ContactPerson1['name'] ?: null,
                "link" =>  (integer) $event->ContactPerson1['student_id'] ?: 0,
                "image" => (string) $event->ContactPerson1['image'] ?: null
            ],
            [
                "name" => (string) $event->ContactPerson1['name'] ?: null,
                "link" =>  (integer) $event->ContactPerson1['student_id'] ?: 0,
                "image" => (string) $event->ContactPerson1['image'] ?: null
            ],
            ],
        "created"=> [
            "by" => [
                "name" => (string) $event->Owner['name'] ?: null,
                "link" =>  (integer) $event->Owner['student_id'] ?: 0,
                "image" => (string) $event->Owner['image'] ?: null
                ],
            "at" => $event->time_created ?: 0,
            ],
        "Actions"=> [
            "Bookmarked"=> [
                "status"=>(bool) $this->params['value'] ?: false, 
                "total" =>(integer) $this->params['total'] ?: 0,
            ],
            "Participants"=> [
                "status"=>(bool) $event->created_by_id ?: false, 
                "total" =>(integer) $event->created_by_id ?: 0,
            ],
            "Bookmarked"=> [
                "status"=>(bool) $event->created_by_id ?: false, 
                "total" =>(integer) $event->created_by_id ?: 0,
            ],
            ],
            "tags"=> [
                [
                "name" => (string) $event->Tag['name'] ?: null,
                "link" =>  (integer) $event->Tag['tag_id'] ?: 0,
                ],
                            "total" =>(integer) $event->created_by_id ?: 0,
            ],
        "links" => [
            "self" => "/events/{$event->id}",
        ],
        ];
    }
    public function includeBookmarks(Event $event) {
        $bookmarks = $event->StudentsBookmarked;

        return $this->collection($bookmarks, new EventBookmarksTransformer);
    }
    public function includeBookmarks(Event $event) {
        $bookmarks = $event->StudentsBookmarked;

        return $this->collection($bookmarks, new EventBookmarksTransformer);
        }





//	private $params = [];

//	function __construct($params = []) {
//		$this->params = $params;
//		$this->params['value'] = false;
//	}

//	public function transform(Event $event) {
//		$total_bookmarks = $event->Bookmarked;
//		$this->params['total'] = count($total_bookmarks);
//		$bookmarks = $event->Bookmarked->where(['student_id' => $this->params['student_id']]);
//		if (count($bookmarks) > 0) {
//			$this->params['value'] = true;
//		} else {
//			$this->params['value'] = false;
//		}
//		return [
//			"event_id" => (integer) $event->event_id ?: 0,
//			"college_id" => (integer) $event->college_id ?: 0,
//			"created_by_id" => (integer) $event->created_by_id ?: 0,
//			"title" => (string) $event->title ?: null,
//			"subtitle" => (string) $event->subtitle ?: null,
//			"description" => (string) $event->description ?: null,
//			"contactperson1" => (integer) $event->contactperson1 ?: 0,
//			"contactperson2" => (integer) $event->contactperson2 ?: 0,
//			"venue" => (string) $event->venue ?: null,
//			"inter" => (integer) $event->inter ?: 0,
//			"time_created" => $event->time_created ?: 0,
//			"type" => $event->Type['name'],
//			"price" => (integer) $event->price ?: 0,
//			"created_by" => (string) $event->Owner['name'] ?: null,
//			"participants" => $event->Participants,
//			"Owner" => $event->Owner->name ?: null,
//			"links" => [
//				"self" => "/events/{$event->id}",
//			],
//			"current_student_id" => $this->params['student_id'],
//			"total_bookmarks" => $this->params['total'],
//			"bookmarked" => $this->params['value'],
//		];
//	}




}