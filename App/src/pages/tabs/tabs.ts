import { Component } from '@angular/core';

import { AddPage } from '../add_tec/add_tc';
import { ContactPage } from '../contact/contact';
import { ViewPage } from '../view/view';

@Component({
  templateUrl: 'tabs.html'
})
export class TabsPage {

  tab1Root = ViewPage;
  tab2Root = AddPage;
  //tab3Root = ContactPage;
  constructor() {
  }


}
