import {Component, OnInit, OnChanges, Output, Input} from "@angular/core";
import {ParkService} from "../services/park-service";
import {Park} from "../classes/park";
import {Observable} from "rxjs";
import "rxjs/add/observable/from";
import {PointDistance} from "../classes/point-distance";

@Component({
	selector: "park",
	templateUrl: "./templates/park.php"
})

export class ParkComponent implements OnChanges {

	@Input() lat: number;
	@Input() lng: number;
	@Output() parksFiltered: Park[] = [];
	parkObservable: Observable<Park> = null;

	constructor(private parkService: ParkService) {
	}

	ngOnChanges(): void {
		this.getParkByParkGeometry();
	}

	getParksFiltered(): Park[] {
		return (this.parksFiltered);
	}

	getParkByParkGeometry(): void {
		let pointDistance = new PointDistance(this.lng, this.lat, 5);
		this.parkService.getParkByParkGeometry(pointDistance).subscribe(parks => {
			this.parkObservable = Observable.from(parks);
			this.parksFiltered = parks.slice(0, 50);
		});
	}
}
