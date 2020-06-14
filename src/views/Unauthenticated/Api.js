import gql from 'graphql-tag'

export const GET_ENUM = gql`
  query GET_ENUM($name: String!) {
    __type(name: $name) {
      enumValues {
        name
      }
    }
  }
`

export const USER_REGISTER = gql`
  mutation USER_REGISTER(
    $username: String!
    $password: String!
    $email: String!
    $first_name: String!
    $last_name: String!
    $gender: Gender!
  ) {
    createUser(
      input: {
        username: $username
        password: $password
        email: $email
        identity: {
          create: {
            first_name: $first_name
            last_name: $last_name
            gender: $gender
          }
        }
      }
    ) {
      username
    }
  }
`

export const USER_LOGIN = gql`
  mutation USER_LOGIN($username: String!, $password: String!) {
    login(input: { username: $username, password: $password }) {
      access_token
      expires_in
    }
  }
`

export const FORGOT_PASSWORD = gql`
  mutation FORGOT_PASSWORD($username: String!) {
    forgotPassword(input: { username: $username }) {
      status
      statusCode
      message
    }
  }
`

export const RESET_PASSWORD = gql`
  mutation RESeT_PASSWORD($username: String!, $password: String!, $otp: Int!) {
    resetPassword(
      input: { username: $username, password: $password, otp: $otp }
    ) {
      status
      statusCode
      message
    }
  }
`
