import React from 'react'
import { render } from 'react-dom'
import { createBrowserHistory } from 'history'
import { Router, Route, Switch, Redirect } from 'react-router-dom'
import ApolloClient from 'apollo-boost'
import { ApolloProvider } from '@apollo/react-hooks'

import AdminLayout from 'layouts/Admin/Admin.js'
import UnauthenticatedLayout from 'layouts/Unauthenticated/Unauthenticated.js'
import RTLLayout from 'layouts/RTL/RTL.js'

import 'assets/scss/black-dashboard-react.scss'
import 'assets/demo/demo.css'
import 'assets/css/nucleo-icons.css'

const hist = createBrowserHistory()

const client = new ApolloClient({
  uri: 'https://api.raymond.digital/graphql',
  request: (operation) => {
    const token = localStorage.getItem('token')
    operation.setContext({
      headers: {
        authorization: token ? `Bearer ${token}` : '',
      },
    })
  },
})

const App = () => (
  <ApolloProvider client={client}>
    <Router history={hist}>
      <Switch>
        <Route exact path="/" render={(props) => <AdminLayout {...props} />} />
        <Route
          exact
          path="/user-profile"
          render={(props) => <AdminLayout {...props} />}
        />
        <Route path="/rtl" render={(props) => <RTLLayout {...props} />} />
        <Route
          path="/login"
          render={(props) => <UnauthenticatedLayout {...props} />}
        />
        <Route
          path="/register"
          render={(props) => <UnauthenticatedLayout {...props} />}
        />
        <Redirect from="*" to="/" />
      </Switch>
    </Router>
    ,
  </ApolloProvider>
)

render(<App />, document.getElementById('root'))
