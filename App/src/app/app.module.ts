import { NgModule, ErrorHandler } from '@angular/core';
import { BrowserModule } from '@angular/platform-browser';
import { IonicApp, IonicModule, IonicErrorHandler } from 'ionic-angular';
import { MyApp } from './app.component';

import { Camera, CameraOptions } from '@ionic-native/camera';
import { FileTransfer, FileUploadOptions, FileTransferObject } from '@ionic-native/file-transfer';
import { Geolocation } from '@ionic-native/geolocation';

import { AddPage } from '../pages/add_tec/add_tc';
import { ContactPage } from '../pages/contact/contact';
import { ViewPage } from '../pages/view/view';
import { LoginPage } from '../pages/login/login';
import { TabsPage } from '../pages/tabs/tabs';
import { DamagePage } from '../pages/Damage/damage';
import { OTPPage } from '../pages/otp/otp';
import {HttpModule} from '@angular/http';

import { StatusBar } from '@ionic-native/status-bar';
import { SplashScreen } from '@ionic-native/splash-screen';
import { UserProvider } from '../providers/user/user';

@NgModule({
  declarations: [
    MyApp,
    AddPage,
    ContactPage,
    ViewPage,
    TabsPage,
    OTPPage,
    DamagePage,
    LoginPage
  ],
  imports: [
    BrowserModule,
    HttpModule,
    IonicModule.forRoot(MyApp)
  ],
  bootstrap: [IonicApp],
  entryComponents: [
    MyApp,
    AddPage,
    ContactPage,
    ViewPage,
    TabsPage,
    OTPPage,
    DamagePage,
    LoginPage
  ],
  providers: [
    Camera,
    FileTransfer,
    Geolocation,
    StatusBar,
    SplashScreen,
    {provide: ErrorHandler, useClass: IonicErrorHandler},
    UserProvider
  ]
})
export class AppModule {}
