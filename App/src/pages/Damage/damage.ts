import { Component,ViewChild,ElementRef  } from '@angular/core';
import {NavController, App, LoadingController, AlertController, Platform, ActionSheetController} from 'ionic-angular';
import { Camera, CameraOptions } from '@ionic-native/camera';
import {LoginPage} from "../login/login";
import { FileTransfer, FileUploadOptions, FileTransferObject } from '@ionic-native/file-transfer';
import {Geolocation} from "@ionic-native/geolocation";


import 'rxjs/add/operator/retry';
import 'rxjs/add/operator/timeout';
import 'rxjs/add/operator/delay';
import 'rxjs/add/operator/map';
import {Http,Headers,RequestOptions,URLSearchParams} from "@angular/http";

declare var google:any;

@Component({
  selector: 'page-damage',
  templateUrl: 'damage.html'
})
export class DamagePage {

  @ViewChild("map") mapElement:ElementRef;
  public pic:any;
  public comment="";
  public width:any;
  public height:any;
  public uploadpic:any=[];
  public imgdata:any;
  public lat:any;
  public lng:any;

  public immage64:any;
  data:any = {};

  constructor(public navCtrl: NavController,public platform:Platform,public actionsheetCtrl: ActionSheetController,public camera: Camera,public app:App,public transfer: FileTransfer,public geolocation:Geolocation,public loadingCtrl:LoadingController,public alertCtrl:AlertController,public http:Http) {
    this.getlocation();
    this.data.image = '';
    this.data.lat = '';
    this.data.lng = '';
    this.data.comment = '';
    this.data.phone = '';
  }

  private getlocation()
  {
    this.geolocation.getCurrentPosition().then((position) => {

      let latLng = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);

      this.lat = position.coords.latitude;
      this.lng = position.coords.longitude;

      console.log("test1", this.lat);
      console.log("test2", this.lng);
    });

  }


  picupload() {
    let actionSheet = this.actionsheetCtrl.create({
      title: 'Picture upload',
      cssClass: 'action-sheets-basic-page',
      buttons: [
        {
          text: 'Upload from gallery',
          icon: !this.platform.is('ios') ? 'image' : null,
          handler: () => {
            console.log('Upload from gallery clicked');

            const options: CameraOptions = {
              destinationType: this.camera.DestinationType.FILE_URI,
              sourceType     : this.camera.PictureSourceType.PHOTOLIBRARY
            }

            this.camera.getPicture(options).then((imageData) => {
              // imageData is a base64 encoded string
              this.pic = imageData;
              this.imgdata = imageData;
              this.immage64 = 'data:image/jpeg;base64,' + imageData;
            }, (err) => {
              console.log(err);
            });



          }
        },
        {
          text: 'Take Picture',
          icon: !this.platform.is('ios') ? 'camera' : null,
          handler: () => {
            console.log('Take Picture clicked');
            this.getlocation();
            const options: CameraOptions = {
              quality: 50,
              //destinationType: this.camera.DestinationType.DATA_URL,
              //encodingType: this.camera.EncodingType.JPEG,
              //mediaType: this.camera.MediaType.PICTURE
            }

            this.camera.getPicture(options).then((imageData) => {
              // imageData is either a base64 encoded string or a file URI
              // If it's base64:
              this.pic = imageData;
              this.imgdata = imageData;
              this.immage64 = 'data:image/jpeg;base64,' + imageData;
            }, (err) => {
              alert(err);
            });
          }
        },
        {
          text: 'Cancel',
          role: 'cancel', // will always sort to be on the bottom
          icon: !this.platform.is('ios') ? 'close' : null,
          handler: () => {
            console.log('Cancel clicked');
          }
        }
      ]
    });
    actionSheet.present();

    //this.getlocation();

    /*this.camera.getPicture({
      /*destinationType: this.camera.DestinationType.DATA_URL,
      targetWidth: 1000,
      targetHeight: 1000

      quality: 100,
      destinationType: this.camera.DestinationType.DATA_URL,
      encodingType: this.camera.EncodingType.JPEG,
      mediaType: this.camera.MediaType.PICTURE

    }).then((imageData) => {
      // imageData is a base64 encoded string
      this.pic = imageData;
      this.imgdata=imageData;
      this.immage64 = "data:image/jpeg;base64," + imageData;
    }, (err) => {
      console.log(err);
    });*/


    //const options: CameraOptions = {
      //quality: 50,
      //destinationType: this.camera.DestinationType.DATA_URL,
      //encodingType: this.camera.EncodingType.JPEG,
      //mediaType: this.camera.MediaType.PICTURE
    //}

    //this.camera.getPicture(options).then((imageData) => {
      // imageData is either a base64 encoded string or a file URI
      // If it's base64:
      //this.pic = imageData;
      //this.imgdata=imageData;
      //this.immage64 = 'data:image/jpeg;base64,' + imageData;
    //}, (err) => {
      //alert(err);
    //});

  }

  send()
  {
    this.getlocation();
    this.loadingCtrl.create({
      content: 'Please wait...',
      duration: 4000,
      dismissOnPageChange: true
    }).present();
    //alert(this.lat);
    //alert(this.log);
    if(this.imgdata!=null)
    {
      if(this.lat!=null && this.lng!=null ) {
        this.loadingCtrl.create({
          content: 'Please wait...',
          duration: 4000,
          dismissOnPageChange: true
        }).present();


        const fileTransfer: FileTransferObject = this.transfer.create();

        if(this.comment==null)
        {
          this.comment="";
        }

        var options = {
          fileKey: "file",
          fileName: "name.png",
          chunkedMode: false,
          mimeType: "image/jpg",
          params : {'comment':this.comment,'lat':this.lat,'lng':this.lng,'phone':localStorage.getItem('phone')} // directory represents remote directory,  fileName represents final remote file name
        };

       fileTransfer.upload(this.imgdata, 'http://mygelaxytest.dialog.lk/MyGalaxy/Fiber/get_damage.php', options)
        //fileTransfer.upload(this.imgdata, 'http://172.22.170.97/fib/get_damage.php', options)
            .then((data) => {
              // success
              this.uploadpic=JSON.parse(data.response);
              console.log("Upload Pic",this.uploadpic);
              //console.log("Data",JSON.stringify(data));

              console.log("status",this.uploadpic.status);

              this.loadingCtrl.create({
                content: 'Please wait...',
                duration: 8000,
                dismissOnPageChange: true
              }).present();

              if(this.uploadpic.status=="200") {
                var prompt_1 = this.alertCtrl.create({
                  title: 'Success',
                  message: "Data updated successfully",
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

                this.pic = null;
                this.comment = null;
                this.imgdata = null;
                this.lat = null;
                this.lng = null;
              }
              else if(this.uploadpic.status=="400")
              {
                var prompt_1 = this.alertCtrl.create({
                  title: 'Error',
                  message: "Error in file Upload",
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

                this.pic = null;
                this.comment = null;
                this.imgdata = null;
                this.lat = null;
                this.lng = null;
              }
              else if(this.uploadpic.status=="800")
              {
                var prompt_1 = this.alertCtrl.create({
                  title: 'Error',
                  message: "System Error :  while file upload Try again later",
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

                this.pic = null;
                this.comment = null;
                this.imgdata = null;
                this.lat = null;
                this.lng = null;
              }
              else
              {
                var prompt_1 = this.alertCtrl.create({
                  title: 'Error',
                  message: "System Error Try again later",
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

                this.pic = null;
                this.comment = null;
                this.imgdata = null;
                this.lat = null;
                this.lng = null;
              }

            }, (err) => {
              //alert("error" + JSON.stringify(err));
              var prompt_1 = this.alertCtrl.create({
                title: 'Error',
                message: "System Error:404 Try again later",
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
            });
      }
      else
      {
        var prompt_1 = this.alertCtrl.create({
          title: 'Error',
          message: "Check Location service settings in your mobile",
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
        message: "Take a picture and upload",
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
    this.pic=null;
    this.comment=null;
    this.imgdata=null;
  }

  logout()
  {
    localStorage.clear();
    this.app.getRootNav().setRoot(LoginPage);
  }

}

