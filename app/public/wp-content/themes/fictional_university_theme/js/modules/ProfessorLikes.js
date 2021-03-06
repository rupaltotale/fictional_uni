import $ from 'jquery';

class ProfessorLikes{
	//1. describe and initiate object
	constructor(){
		// alert("This is ProfessorLikes");
		this.likeButton = $("#like-button");
		this.likeBox = $(".like-box");
		this.likeCountSpan = $(".like-count");
		this.likeCount = parseInt(this.likeCountSpan.text()); // convert to number
		this.events();

	}

	//2. Events
	events() {
		this.likeBox.on("click", this.likeButton, this.likeOrDislikeNote.bind(this));


	}

	//3. Methods
	likeOrDislikeNote(){
		var profID = this.likeBox.attr('id');
		console.log(profID);
		var ajax_url = universityData.ajax_url;

		var data = {
			'userLikesArray' : ['Apple', 'Banana'],
			// action: 'like_prof',
			// id: profID, 
		};
		// $.post(ajax_url, data, function(response) {
		// 	console.log(response);
		// });
		$.ajax({
			method: "POST",
			url: universityData.root_url + '/wp-json/university/v1/prof?ID=' + profID,
			data: data,
			beforeSend: function ( xhr ) {
				xhr.setRequestHeader( 'X-WP-Nonce', universityData.nonce );
			},
			success : function( response ) {
				console.log("Yay, it works");
				console.log(response);
			},
			error: function(response){
				console.log("Nay, it doesn't work");
			}
		});
		$.ajax({
			method: "GET",
			url: universityData.root_url + '/wp-json/university/v1/prof?ID=' + profID,
			// data: data,
			beforeSend: function ( xhr ) {
				xhr.setRequestHeader( 'X-WP-Nonce', universityData.nonce );
			},
			success : function( response ) {
				console.log("Yay, it works");
				console.log(response);
			},
			error: function(response){
				console.log("Nay, it doesn't work");
			}
		});
		// $.ajax({
		// 	method: "POST",
		// 	url: universityData.root_url + '/wp-json/wp/v2/professor/' + profID,
		// 	data: {
		// 		content: "Subscriber can edit this professor",
		// 	},
		// 	beforeSend: function ( xhr ) {
		// 		xhr.setRequestHeader( 'X-WP-Nonce', universityData.nonce );
		// 	},
		// 	success : function( response ) {
		// 		console.log(response);
		// 	},
		// 	error: function(response){
		// 		console.log(response)
		// 	}
		// });
		if(this.likeBox.data("exists") == "yes"){
			// disliking
			this.likeBox.data("exists", "no");
			this.likeBox.attr('data-exists','no');
			this.likeCount--;
			this.likeCountSpan.html(this.likeCount);
			
		}
		else if(this.likeBox.data("exists") == "no"){
			//liking
			this.likeBox.data("exists", "yes");
			this.likeBox.attr('data-exists','yes');	
			this.likeCount++;
			this.likeCountSpan.html(this.likeCount);		

		}
	}
	

}
export default ProfessorLikes;