import React from 'react'
import gql from 'graphql-tag'
import { useQuery, useMutation } from '@apollo/react-hooks'

// reactstrap components
import {
  Button,
  Card,
  CardHeader,
  CardBody,
  CardFooter,
  CardText,
  FormGroup,
  Form,
  Input,
  Row,
  Col,
} from 'reactstrap'

const USER_PROFILE = gql`
  query USER_PROFILE($id: ID!) {
    user(id: $id) {
      username
      email
      identity {
        id
        first_name
        last_name
        gender
        photo_url
        contact_number
      }
    }
  }
`

const UserProfile = (props) => {
  const { loading, error, data } = useQuery(USER_PROFILE, {
    variables: { id: 1 },
  })

  if (loading) return <p>Loading...</p>
  if (error) return `Error! ${error}`

  const { username, email, identity } = data.user

  return (
    <div className="content">
      <Row>
        {/*  <Col md="8">
          <Card>
            <CardHeader>
              <h5 className="title">Edit Profile</h5>
            </CardHeader>
            <CardBody>
              <Form>
                <Row>
                  <Col className="px-md-1" md="6">
                    <FormGroup>
                      <label>ID</label>
                      <Input defaultValue={identity.id} type="text" />
                    </FormGroup>
                  </Col>
                  <Col className="px-md-1" md="6">
                    <FormGroup>
                      <label>Username</label>
                      <Input defaultValue={username} type="text" />
                    </FormGroup>
                  </Col>
                  <Col className="px-md-1" md="6">
                    <FormGroup>
                      <label>Username</label>
                      <Input defaultValue={identity.gender} type="text" />
                    </FormGroup>
                  </Col>
                  <Col className="px-md-1" md="6">
                    <FormGroup>
                      <label>First Name</label>
                      <Input defaultValue={identity.first_name} type="text" />
                    </FormGroup>
                  </Col>
                  <Col className="px-md-1" md="6">
                    <FormGroup>
                      <label>Last Name</label>
                      <Input defaultValue={identity.last_name} type="text" />
                    </FormGroup>
                  </Col>
                  <Col className="px-md-1" md="6">
                    <FormGroup>
                      <label>Email</label>
                      <Input defaultValue={email} type="email" />
                    </FormGroup>
                  </Col>
                  <Col className="px-md-1" md="6">
                    <FormGroup>
                      <label>Phone Number</label>
                      <Input
                        defaultValue={identity.contact_number}
                        type="text"
                      />
                    </FormGroup>
                  </Col>
                </Row>
                <Row>
                  <Col md="8">
                    <FormGroup>
                      <label>About Me</label>
                      <Input
                        cols="80"
                        defaultValue="Lamborghini Mercy, Your chick she so thirsty, I'm in
                            that two seat Lambo."
                        placeholder="Here can be your description"
                        rows="4"
                        type="textarea"
                      />
                    </FormGroup>
                  </Col>
                </Row>
              </Form>
            </CardBody>
            <CardFooter>
              <Button className="btn-fill" color="primary" type="submit">
                Save
              </Button>
            </CardFooter>
          </Card>
        </Col> */}
        <Col md="12">
          <Card className="card-user">
            <CardBody>
              <CardText />
              <div className="author">
                <div className="block block-one" />
                <div className="block block-two" />
                <div className="block block-three" />
                <div className="block block-four" />
                <a href="#pablo" onClick={(e) => e.preventDefault()}>
                  <img
                    alt="..."
                    className="avatar"
                    src={require('assets/img/emilyz.jpg')}
                  />
                  <h3 className="title my-1">{`${identity.first_name} ${identity.last_name}`}</h3>
                  <h5 className="title mb-4">{email}</h5>
                </a>
                <p className="description">Ceo/Co-Founder</p>
              </div>
              <div className="card-description my-6 mx-3">
                <Row style={{ maxWidth: 300, lineHeight: 2.53 }}>
                  <Col md="12" className="title">
                    User Information
                  </Col>
                  <Col md="6">ID :</Col>
                  <Col md="6">{identity.id}</Col>
                  <Col md="6">Username :</Col>
                  <Col md="6">{username}</Col>
                  <Col md="6">Gender :</Col>
                  <Col md="6">{identity.gender}</Col>
                  <Col md="6">Phone :</Col>
                  <Col md="6">{identity.contact_number}</Col>
                </Row>
              </div>
            </CardBody>
            <CardFooter>
              <div className="button-container">
                <Button className="btn-icon btn-round" color="facebook">
                  <i className="fab fa-facebook" />
                </Button>
                <Button className="btn-icon btn-round" color="twitter">
                  <i className="fab fa-twitter" />
                </Button>
                <Button className="btn-icon btn-round" color="google">
                  <i className="fab fa-google-plus" />
                </Button>
              </div>
            </CardFooter>
          </Card>
        </Col>
      </Row>
    </div>
  )
}

export default UserProfile
