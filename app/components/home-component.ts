import {Component} from "@angular/core";

@Component({
	templateUrl: "./templates/home.php"
})

export class HomeComponent {
	title: string = 'ABQuery';
	lat: number = 35.105332;
	lng: number = -106.629385;
}
