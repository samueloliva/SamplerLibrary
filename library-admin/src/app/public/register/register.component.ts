import { HttpClient } from '@angular/common/http';
import { Component, OnInit } from '@angular/core';
import { FormBuilder, FormGroup, Validators } from '@angular/forms';

@Component({
  selector: 'app-register',
  templateUrl: './register.component.html',
  styleUrls: ['./register.component.sass']
})
export class RegisterComponent implements OnInit {

  form!: FormGroup;
  server: any;
  message: any;

  constructor(private fb: FormBuilder,
              private http: HttpClient) { }

  ngOnInit() {
    this.form = this.fb.group({
      name: ['', Validators.required],
      email: ['', [Validators.required, Validators.email]],
      date_of_birth: ['', Validators.required],
      password: ['', Validators.required],
      password_confirmation: ['', Validators.required]
    });
  }

  submit() {
    const formData = this.form.getRawValue();

    this.http.post('http://localhost:8000/api/register', formData).subscribe(
      response => { 
        this.server = JSON.parse(JSON.stringify(response))
        if (this.server.code == 200) 
          alert(this.server.message)
        else 
          this.message = this.server.message
      },
      err => this.message = err.statusText
    );

  }

}
