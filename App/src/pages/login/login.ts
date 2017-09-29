import { Component } from '@angular/core';
import {NavController, App, AlertController, LoadingController} from 'ionic-angular';
import {TabsPage} from "../tabs/tabs";
import {DamagePage} from "../Damage/damage";
import {Http,Headers,RequestOptions,URLSearchParams} from "@angular/http";
import 'rxjs/add/operator/retry';
import 'rxjs/add/operator/timeout';
import 'rxjs/add/operator/delay';
import 'rxjs/add/operator/map';
import {OTPPage} from "../otp/otp";
import {UserProvider} from "../../providers/user/user";

@Component({
  selector: 'page-login',
  templateUrl: 'login.html'
})
export class LoginPage {

  public phone:any;
  public user:any=[];

  constructor(public navCtrl: NavController,public app:App,public alertCtrl:AlertController,public loadingCtrl:LoadingController,public http:Http,public tec:UserProvider) {

  }

  login()
  {
      this.loadingCtrl.create({
          content: 'Please wait...',
          duration: 4000,
          dismissOnPageChange: true
      }).present();

      if(this.verify()) {
          let headers = new Headers({'Content-Type': 'application/json'});
          let body = new FormData();
          body.append('phone', this.phone);

          //this.http.post("http://172.22.170.97/fib/login_phone.php",body,headers).timeout(3000)
          this.http.post("http://mygelaxytest.dialog.lk/MyGalaxy/Fiber/login_phone.php", body, headers).timeout(3000)
              .map(res => res.json())
              .subscribe(data => {
                  console.log(data);
                  this.user = data;

                  if (this.user.status == "200") {
                      this.tec.setphone(this.phone);
                      this.phone = "";
                      // this.app.getRootNav().setRoot(OTPPage);
                      var prompt_1 = this.alertCtrl.create({
                          title: 'Success',
                          message: "You will receive a OTP password",
                          buttons: [
                              {
                                  text: 'Ok',
                                  handler: function (data) {
                                      console.log('Ok');
                                  }
                              }
                          ]
                      });
                      prompt_1.present();

                      this.navCtrl.push(OTPPage);
                  }
                  else {
                      var prompt_1 = this.alertCtrl.create({
                          title: 'Error',
                          message: "System Error while Login Try the system later",
                          buttons: [
                              {
                                  text: 'Ok',
                                  handler: function (data) {
                                      console.log('Ok');
                                  }
                              }
                          ]
                      });
                      prompt_1.present();
                      this.phone = "";
                  }
              }, (err) => {
                  this.loadingCtrl.create({
                      content: 'Please wait...',
                      duration: 1000,
                      dismissOnPageChange: true
                  }).present();
                  this.phone = "";
                  let prompt = this.alertCtrl.create({
                      title: 'Server not found : 404',
                      message: "Check the system later ",

                      buttons: [
                          {
                              text: 'Ok',
                              handler: data => {
                                  console.log('Ok');
                              }
                          }
                      ]
                  });
                  prompt.present();
              });
      }
      else
      {
          let prompt = this.alertCtrl.create({
              title: 'Error',
              message: "Enter your phone number correctly",

              buttons: [
                  {
                      text: 'Ok',
                      handler: data => {
                          console.log('Ok');
                      }
                  }
              ]
          });
          prompt.present();
      }
  }
  clear()
  {
    this.phone="";
  }

  verify()
  {
      var ret=false;
      var len;
      if(isNaN(this.phone))
      {
          ret=false;
      }
      else
      {
          if (this.phone.charAt(0) == "0") {
              len = 10;
          }
          else {
              len = 10;
              this.phone="0"+this.phone;
          }

          if(this.phone.length!=len)
          {
              ret=false;
          }
          else
          {
              if(this.phone.charAt(1)=="7" &&(this.phone.charAt(2)=="7" || this.phone.charAt(2)=="6" || this.phone.charAt(2)=="5" || this.phone.charAt(2)=="1" || this.phone.charAt(2)=="2" || this.phone.charAt(2)=="8" ||  this.phone.charAt(2)=="0") )
              ret=true;
          }
      }

      return ret;
  }

}
