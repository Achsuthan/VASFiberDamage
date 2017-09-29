import { Injectable } from '@angular/core';
import { Http } from '@angular/http';
import 'rxjs/add/operator/map';

/*
  Generated class for the UserProvider provider.

  See https://angular.io/docs/ts/latest/guide/dependency-injection.html
  for more info on providers and Angular DI.
*/
@Injectable()
export class UserProvider {
  public phone:any;

  constructor(public http: Http) {
    console.log('Hello UserProvider Provider');
  }
  setphone(phone)
  {
    this.phone=phone;
  }
  getphone()
  {
    return this.phone;
  }

}
