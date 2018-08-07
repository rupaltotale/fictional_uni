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
		var ajax_url = "http://fictional-uni.local/wp-admin/admin-ajax.php";
		var data = {
			action: 'my_update_pm',
			id: profID, 
			cote: 'like'
		};
		$.post(ajax_url, data, function(response) {
    // whatever you need to do; maybe nothing
});
		if(this.likeBox.data("exists") == "yes"){
			// disliking
			this.likeBox.data("exists", "no");
			this.likeBox.attr('data-exists','no');
			this.likeCount--;
			this.likeCountSpan.html(this.likeCount);
			
		}
		else{
			//liking
			this.likeBox.data("exists", "yes");
			this.likeBox.attr('data-exists','yes');	
			this.likeCount++;
			this.likeCountSpan.html(this.likeCount);		

		}
	}
	

}
export default ProfessorLikes;