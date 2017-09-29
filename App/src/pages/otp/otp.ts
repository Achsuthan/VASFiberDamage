import { Component,ViewChild } from '@angular/core';
import {NavController, App, AlertController, LoadingController, TextInput} from 'ionic-angular';
import {TabsPage} from "../tabs/tabs";
import {DamagePage} from "../Damage/damage";
import {Http,Headers,RequestOptions,URLSearchParams} from "@angular/http";
import 'rxjs/add/operator/retry';
import 'rxjs/add/operator/timeout';
import 'rxjs/add/operator/delay';
import 'rxjs/add/operator/map';
import {UserProvider} from "../../providers/user/user";


@Component({
  selector: 'page-otp',
  templateUrl: 'otp.html'
})
export class OTPPage {

    @ViewChild('num2') public num2:TextInput ;
    @ViewChild('num3') public num3:TextInput ;
    @ViewChild('num4') public num4:TextInput ;

  public array_otp:any=[];
  public otp:any;

  constructor(public navCtrl: NavController,public app:App,public alertCtrl:AlertController,public loadingCtrl:LoadingController,public http:Http,public tec:UserProvider) {
      console.log(this.tec.getphone());
  }

  verify()
  {
      if(this.otp!=null) {
          console.log("OTP",this.otp);
          console.log("phone",this.tec.getphone());

          let headers = new Headers({ 'Content-Type': 'application/json' });
          let body = new FormData();
          body.append('phone', this.tec.getphone());
          body.append('otp',this.otp);


          //this.http.post("http://172.22.170.97/fib/otp_check.php",body,headers).timeout(3000)
          this.http.post("http://mygelaxytest.dialog.lk/MyGalaxy/Fiber/otp_check.php",body,headers).timeout(3000)
              .map(res => res.json())
              .subscribe(data => {
                  console.log(data);

                  this.loadingCtrl.create({
                      content: 'Please wait...',
                      duration: 4000,
                      dismissOnPageChange: true
                  }).present();


                  this.array_otp = data;

                  if (this.array_otp.status == "200") {
                      localStorage.setItem("phone", this.tec.getphone());
                      this.app.getRootNav().setRoot(DamagePage);
                  }
                  else {
                      var prompt_1 = this.alertCtrl.create({
                          title: 'Error',
                          message: "Enter valid OTP",
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
                      this.otp = "";
                  }

              }, (err) => {
                  this.loadingCtrl.create({
                      content: 'Please wait...',
                      duration: 1000,
                      dismissOnPageChange: true
                  }).present();
                  this.otp = "";
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
              message: "Enter OTP password",

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
  resend()
  {
    this.otp="";
      let headers = new Headers({ 'Content-Type': 'application/json' });
      let body = new FormData();
      body.append('phone', this.tec.getphone());
      //this.http.post("http://172.22.170.97/fib/login_phone.php",body,headers).timeout(3000)
      this.http.post("http://mygelaxytest.dialog.lk/MyGalaxy/Fiber/login_phone.php",body,headers).timeout(3000)
          .map(res => res.json())
          .subscribe(data => {
              console.log(data);
              this.array_otp = data;

              if (this.array_otp.status == "200") {

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
              }
              else
              {
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
              }
          }, (err) => {
              this.loadingCtrl.create({
                  content: 'Please wait...',
                  duration: 1000,
                  dismissOnPageChange: true
              }).present();
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
  onKeyEvent()
  {
      if(this.otp.length==4)
      {
          this.verify();
      }
  }

}
