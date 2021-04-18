import { Component, OnInit } from '@angular/core';
import { FormBuilder, FormGroup } from '@angular/forms';
import { HttpClient } from '@angular/common/http';
import { Router } from '@angular/router';

@Component({
  selector: 'app-login',
  templateUrl: './login.component.html',
  styleUrls: ['./login.component.sass']
})
export class LoginComponent implements OnInit {

  form: any;
  error: any;

  constructor(private fb: FormBuilder, 
              private http: HttpClient,
              private router: Router) { 
  }

  ngOnInit() {
    this.form = this.fb.group( {
      email: '',
      password: ''
    });
  }

  submit() {
    const formData = this.form.getRawValue();

    const data = {
      username: formData.email,
      password: formData.password,
      grant_type: 'password',
      client_id: 2,
      client_secret: '59V2OHSbTSpAtrZgnfzKh0FxQnG2a6tXLXzdgwhY',
      scope: '*'
    };

    this.http.post<any>('http://localhost:8000/oauth/token', data ).subscribe({
      next: (result: any) => {
        localStorage.setItem( 'token', result.access_token);
        this.router.navigate(['/secure']);
      },
      error: err => console.log(err)
    });
  }

}
