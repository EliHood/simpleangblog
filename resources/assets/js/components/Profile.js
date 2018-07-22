import React, { Component } from 'react';
import ReactDOM from 'react-dom';
import axios from 'axios';


export default class Example extends Component {

	constructor(props){
		super(props);
		let id = JSON.parse(this.props.data);
		// console.log('data from component', JSON.parse(this.props.data));
		this.state = {
			btnText: 'Follow',
			className: 'follow-button',
			user:{
				id:id.id,
				followers: id,
				name:id.name
			},
			posts: ''
		};
	}

	myfollow(user) {
	    axios('/user/follow/'+ this.state.user.id , { method: "POST" })
	      .then(response => {
	        console.log(response);
	      });
	};

	componentDidMount(){

		// console.log('data from component', this.state.user.followers.followedByMe);
		let followed = JSON.parse(this.state.user.followers.followedByMe);

		if (followed === true){	
			this.setState({
		        btnText:'Following', 
		        className:'following-button'
		    });
		}
	}


	


	btnClick(){
		this.myfollow();



	    if(this.state.btnText === 'Follow'){
	      this.setState({
	        btnText:'Following'
	      })
	    } else{
	      this.setState({
	        btnText: 'Follow'
	      })
	    }


	    if(this.state.className === 'follow-button'){
	      this.setState({
	        className: 'following-button'
	      })
	    }
	      else{
	        this.setState({
	          className: 'follow-button'
	        })
	      }

	}


 

	render(){
		return (
	      <div className="followdoe">
	        <button onClick={this.btnClick.bind(this)} className={this.state.className}>
	          <p>{this.state.btnText}</p>



	        </button>
 	      </div>
	    );
	}
    
}
if (document.getElementById('profile')) {
   var data = document.getElementById('profile').getAttribute('data');
   ReactDOM.render(<Example data={data} />, document.getElementById('profile'));
}
