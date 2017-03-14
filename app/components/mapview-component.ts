import { Component, ElementRef, NgZone, OnInit, ViewChild } from '@angular/core';
import { FormControl } from "@angular/forms";
import { AgmCoreModule, MapsAPILoader } from 'angular2-google-maps/core';

declare var google: any;

@Component({
	templateUrl: "./templates/map-view.php"
})

export class MapViewComponent implements OnInit {

	public lat: number;
	public lng: number;
	public searchControl: FormControl;
	public zoom: number;

	@ViewChild("search")
	public searchElementRef: ElementRef;

	constructor(
		private mapsAPILoader: MapsAPILoader,
		private ngZone: NgZone
	) {}

	ngOnInit() {
		//set google maps defaults
		this.zoom = 12;
		this.lat = 35.105332;
		this.lng = -106.629385;

		//create search FormControl
		this.searchControl = new FormControl();

		//set current position
		this.setCurrentPosition();

		//load Places Autocomplete
		this.mapsAPILoader.load().then(() => {
			let autocomplete = new google.maps.places.Autocomplete(this.searchElementRef.nativeElement, {
				types: ["address"]
			});
			autocomplete.addListener("place_changed", () => {
				this.ngZone.run(() => {
					//get the place result
					let place: google.maps.places.PlaceResult = autocomplete.getPlace();

					//verify result
					if (place.geometry === undefined || place.geometry === null) {
						return;
					}

					//set latitude, longitude and zoom
					this.lat = place.geometry.location.lat();
					this.lng = place.geometry.location.lng();
					this.zoom = 12;
				});
			});
		});
	}

	private setCurrentPosition() {
		if ("geolocation" in navigator) {
			navigator.geolocation.getCurrentPosition((position) => {
				this.lat = position.coords.latitude;
				this.lng = position.coords.longitude;
				this.zoom = 12;
			});
		}
	}
}
