import React from 'react'
import { Route, Switch, Redirect } from 'react-router-dom'
// javascript plugin used to create scrollbars on windows
import PerfectScrollbar from 'perfect-scrollbar'

// core components
import AdminNavbar from 'components/Navbars/AdminNavbar.js'
import Footer from 'components/Footer/Footer.js'
import Sidebar from 'components/Sidebar/Sidebar.js'
import FixedPlugin from 'components/FixedPlugin/FixedPlugin.js'

import routes from 'routes.js'

import logo from 'assets/img/react-logo.png'

var ps

class Unauthenticated extends React.Component {
  constructor(props) {
    super(props)
    this.state = {
      backgroundColor: 'red',
    }
  }
  getRoutes = (routes) => {
    return routes.map((prop, key) => {
      if (prop.layout === '/unauthenticated') {
        return (
          <Route exact path={prop.path} component={prop.component} key={key} />
        )
      } else {
        return null
      }
    })
  }
  render() {
    return (
      <>
        <div className="">
          <div
            className="main-panel"
            ref="mainPanel"
            data={this.state.backgroundColor}
          >
            <Switch>
              {this.getRoutes(routes)}
              <Redirect from="*" to="/login" />
            </Switch>
          </div>
        </div>
        {/* <FixedPlugin
          bgColor={this.state.backgroundColor}
          handleBgClick={this.handleBgClick}
        /> */}
      </>
    )
  }
}

export default Unauthenticated
