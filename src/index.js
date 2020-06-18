import React from 'react'
import { render } from 'react-dom'
import { createBrowserHistory } from 'history'
import { Router, Route, Switch, Redirect } from 'react-router-dom'
import ApolloClient from 'apollo-boost'
import { ApolloProvider } from '@apollo/react-hooks'
import { useMutation } from '@apollo/react-hooks'

import AdminLayout from 'layouts/Admin/Admin.js'
import UnauthenticatedLayout from 'layouts/Unauthenticated/Unauthenticated.js'
import RTLLayout from 'layouts/RTL/RTL.js'

import 'assets/scss/black-dashboard-react.scss'
import 'assets/demo/demo.css'
import 'assets/css/nucleo-icons.css'

import auth from './variables/constants.js'
import { REFRESH_TOKEN } from './views/Unauthenticated/Api'

const hist = createBrowserHistory()

// const [refreshToken, { data, error, loading }] = useMutation(REFRESH_TOKEN)

const client = new ApolloClient({
  uri: 'https://api.raymond.digital/graphql',
  // onError: ({ graphQLErrors, networkError, operation, forward }) => {
  //   console.error(networkError, graphQLErrors)
  //   if (graphQLErrors)
  //     graphQLErrors.map(({ message, locations, path }) =>
  //       console.log(
  //         `[GraphQL error]: Message: ${message}, Location: ${locations}, Path: ${path}`
  //       )
  //     )
  //   if (graphQLErrors[0].message === 'Unauthenticated.') {
  //     const doRefresh = async () => {
  //       const data = await refreshToken(localStorage.getItem('refreshToken'))
  //       console.log(data)
  //       if (!data) return forward(operation)

  //       auth.accessToken = data.data.refreshToken.access_token
  //       localStorage.setItem(
  //         'refreshToken',
  //         data.data.refreshToken.refresh_token
  //       )
  //       await operation.setContext({
  //         headers: {
  //           authorization: `Bearer ${auth.accessToken}`,
  //         },
  //       })

  //       return forward(operation)
  //     }

  //     doRefresh()
  //   } else {
  //   }
  // },
  fetchOptions: {
    credentials: 'include',
  },
  request: (operation) => {
    const token = auth.accessToken
    operation.setContext({
      headers: {
        authorization: `Bearer ${token}`,
      },
    })
  },
})

const refreshToken = async (refreshToken) => {
  // Get refresh token from cookies
  console.log('.............................................')
  console.log('refresh auth token with token:')
  console.log(refreshToken)
  console.log('.............................................')
  if (!refreshToken) return null
  // Get new auth token from server
  try {
    return client.mutate({
      mutation: REFRESH_TOKEN,
      variables: {
        refreshToken,
      },
    })
  } catch (e) {
    return null
  }
}

const App = () => {
  const res = refreshToken(localStorage.getItem('refreshToken'))
  console.log(res, 1)
  return (
    <ApolloProvider client={client}>
      <Router history={hist}>
        <Switch>
          <Route
            exact
            path="/"
            render={(props) => <AdminLayout {...props} />}
          />
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
}

render(<App />, document.getElementById('root'))
