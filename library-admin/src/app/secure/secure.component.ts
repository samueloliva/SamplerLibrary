import { HttpClient, HttpHeaders } from '@angular/common/http';
import { Component, OnInit } from '@angular/core';
import { Router } from '@angular/router';
import { FormBuilder, FormGroup, Validators } from '@angular/forms';

@Component({
  selector: 'app-secure',
  templateUrl: './secure.component.html',
  styleUrls: ['./secure.component.sass']
})
export class SecureComponent implements OnInit {

  user: any;
  books: any;
  p: number = 1;
  form!: FormGroup;
  headers: any;
  server: any;
  message: any;

  constructor(private http: HttpClient,
              private router: Router,
              private fb: FormBuilder) { }

  ngOnInit() {
    this.form = this.fb.group({
      book_id: ['', Validators.required],
      book_status: ['', Validators.required],
    });

    this.headers = new HttpHeaders({
      'Authorization': `Bearer ${localStorage.getItem('token')}`      
    });
    
    this.http.get('http://localhost:8000/api/user', {headers: this.headers}).subscribe({
      next: result => this.user = result,
      error: err => {
        localStorage.removeItem('token');
        this.router.navigate(['/login']);
      }
    });

    this.loadData();    
  }

  submit() {
    const formData = this.form.getRawValue();
    formData["user_id"] = this.user.id;

    this.http.post('http://localhost:8000/api/book/change', formData).subscribe(
      response => { 
        this.server = JSON.parse(JSON.stringify(response))
        if (this.server.code == 200) 
          alert(this.server.message)
        else 
          this.message = this.server.message
      },
      err => console.log(err)
    );

    this.loadData();
  }

  loadData() {
    this.http.get('http://localhost:8000/api/book', {headers: this.headers}).subscribe({
      next: result => this.books = result,
      error: err => {
        localStorage.removeItem('token');
        this.router.navigate(['/login']);
      }
    });
  }

}

