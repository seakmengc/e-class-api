import React, { useState } from 'react'
import gql from 'graphql-tag'
import { useMutation } from '@apollo/react-hooks'
import useFrom from '../../lib/useForm'
import { FormWrapper, H3 } from './Styled'
import { FORGOT_PASSWORD } from './Api'
// reactstrap components
import {
  Alert,
  Button,
  Card,
  CardHeader,
  CardBody,
  CardFooter,
  CardText,
  FormGroup,
  FormFeedback,
  Form,
  Input,
  Row,
  Col,
} from 'reactstrap'

const ForgotPassword = (props) => {
  const { inputs, handleChange, resetForm } = useFrom({
    username: '',
  })
  const [isButtonDisabled, setIsButtonDisabled] = useState(false)
  const [forgotPassword, { data, error, loading }] = useMutation(
    FORGOT_PASSWORD,
    {
      variables: inputs,
    }
  )

  return (
    <FormWrapper>
      <Row style={{ width: 700 }}>
        <Col md="12">
          <Card>
            <CardHeader>
              <H3 className="title">Forgot Password</H3>
            </CardHeader>
            {error?.graphQLErrors[0]?.extensions?.reason && (
              <Alert style={{ margin: 30, marginBottom: 0 }} color="danger">
                {error.graphQLErrors[0]?.extensions?.reason}
              </Alert>
            )}
            <CardBody>
              <Form
                onSubmit={async (e) => {
                  e.preventDefault()
                  // setValidation(true)
                  let res
                  try {
                    res = await forgotPassword()
                    console.log(res)
                    // handle data
                    props.history.push('/login/reset-password')
                  } catch {}
                }}
              >
                <Row className="p-3">
                  <Col md="12">
                    <FormGroup>
                      <label>Username</label>
                      <Input
                        placeholder="Username, Phone, or Email"
                        type="text"
                        name="username"
                        onChange={handleChange}
                        required
                      />
                    </FormGroup>
                  </Col>

                  <Col md="12" className="mt-1">
                    <Button
                      type="submit"
                      className="btn-fill"
                      color="primary"
                      disabled={isButtonDisabled}
                    >
                      Reset
                    </Button>
                  </Col>
                </Row>
              </Form>
            </CardBody>
          </Card>
        </Col>
      </Row>
    </FormWrapper>
  )
}

export default ForgotPassword
