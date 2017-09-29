import { Component } from '@angular/core';
import {NavController, AlertController, LoadingController} from 'ionic-angular';
import {Http} from "@angular/http";
import 'rxjs/add/operator/retry';
import 'rxjs/add/operator/timeout';
import 'rxjs/add/operator/delay';
import 'rxjs/add/operator/map';

@Component({
  selector: 'page-add_tc',
  templateUrl: 'add_tc.html'
})
export class AddPage {
  public username:any;
  public password:any;
  public password1:any;
  public email:any;
  public address:any;
  public phone_number:any;
  public firstname:any;
  public lastname:any;

  public register_array:any=[];

  constructor(public navCtrl: NavController,public alertCtrl:AlertController,public http:Http,public loadingCtrl:LoadingController) {

  }

  register()
  {

    if(this.firstname!=null && this.lastname!=null && this.address!=null && this.phone_number!=null && this.username!=null && this.password!=null && this.password1!=null && this.email!=null)
    {
      if(this.password1==this.password)
      {

        this.loadingCtrl.create({
          content: 'Please wait...',
          duration: 4000,
          dismissOnPageChange: true
        }).present();

        this.http.get("+this.lon1")
            .map(res => res.json())
            .subscribe(data => {
              console.log(data);

              this.loadingCtrl.create({
                content: 'Please wait...',
                duration: 4000,
                dismissOnPageChange: true
              }).present();


              this.register_array=data;

              if(this.register_array.status=="200")
              {
                this.firstname="";
                this.lastname="";
                this.address="";
                this.phone_number="";
                this.username="";
                this.password="";
                this.password1="";
                this.email="";

                var prompt_1 = this.alertCtrl.create({
                  title: 'Success',
                  message: "Driver Registered Successfully",
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
              else if(this.register_array.status=="800")
              {
                var prompt_1 = this.alertCtrl.create({
                  title: 'Error',
                  message: "System Error while registering Try the system later",
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

                this.firstname="";
                this.lastname="";
                this.address="";
                this.phone_number="";
                this.username="";
                this.password="";
                this.password1="";
                this.email="";
              }
              else
              {
                var prompt_1 = this.alertCtrl.create({
                  title: 'Error',
                  message: "Driver not registered",
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

                this.firstname="";
                this.lastname="";
                this.address="";
                this.phone_number="";
                this.username="";
                this.password="";
                this.password1="";
                this.email="";
              }

            });
      }
      else
      {
        var prompt_1 = this.alertCtrl.create({
          title: 'Error',
          message: "Your Password Not matched",
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
    }
    else
    {
      var prompt_1 = this.alertCtrl.create({
        title: 'Error',
        message: "Input All values",
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
  }

  clear()
  {
    this.firstname="";
    this.lastname="";
    this.address="";
    this.phone_number="";
    this.username="";
    this.password="";
    this.password1="";
    this.email="";


  }

}
