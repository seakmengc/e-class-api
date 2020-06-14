import React, { useState } from 'react'
import gql from 'graphql-tag'
import { useMutation } from '@apollo/react-hooks'
import useForm from '../../lib/useForm'
import { FormWrapper, H3 } from './Styled'
import { RESET_PASSWORD } from './Api'
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

const ResetPassword = (props) => {
  const { inputs, handleChange, resetForm } = useForm({
    username: '',
    password: '',
    otp: '',
  })

  const [validation, setValidation] = useState(false)
  const [isButtonDisabled, setIsButtonDisabled] = useState(false)
  const [resetPassword, { data, error, loading }] = useMutation(
    RESET_PASSWORD,
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
              <H3 className="title">Reset Password</H3>
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
                    res = await resetPassword()
                    console.log(res)
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
                  <Col md="12">
                    <FormGroup>
                      <label>Validation Code</label>
                      <Input
                        placeholder="123456"
                        type="text"
                        name="otp"
                        onChange={handleChange}
                        required
                      />
                    </FormGroup>
                  </Col>
                  <Col md="12">
                    <FormGroup>
                      <label>New Password</label>
                      <Input
                        placeholder="********"
                        type="password"
                        name="password"
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

export default ResetPassword
