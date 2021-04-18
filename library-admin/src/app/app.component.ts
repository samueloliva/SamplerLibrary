import { Component, OnChanges, OnInit } from '@angular/core';

@Component({
  selector: 'app-root',
  templateUrl: './app.component.html',
  styleUrls: ['./app.component.sass']
})
export class AppComponent implements OnInit{
  loggedIn = false;

  ngOnInit() {
    this.loggedIn = localStorage.getItem('token') !== null;
  }
  
  logout() {
    this.loggedIn = false;
    localStorage.removeItem('token');
  }
}
