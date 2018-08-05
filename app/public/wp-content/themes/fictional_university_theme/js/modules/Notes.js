import $ from 'jquery';

class Notes{
	//1. describe and initiate object
	constructor(){
		this.submitButton = $(".submit-note");
		$(document).ready(this.events());
		this.isEditting = false;
		this.prevTitle = "";
		this.prevBody = "";
		// this.count = universityData.noteCount;

	}

	//2. Events
	events() {
		$("#my-notes").on("click", ".edit-note", this.editNote.bind(this));
		$("#my-notes").on("click", ".delete-note", this.deleteNote.bind(this));
		$("#my-notes").on("click", ".update-note", this.updateNote.bind(this));
		this.submitButton.on("click", this.submitNote.bind(this));

		// runs a functions as soon as a change is made in the text field (.new-note-title)
		$('.new-note-title').bind('input propertychange', function() {
			$('.alert').html("");
		});


	}

	//3. Methods
	deleteNote(e){
		var note = $(e.target).parents("li");
		var noteID = note.attr('id');
		$.ajax({
			method: "DELETE",
			url: universityData.root_url + '/wp-json/wp/v2/note/' + noteID,
			beforeSend: function ( xhr ) {
				xhr.setRequestHeader( 'X-WP-Nonce', universityData.nonce );
			},
			success: (response) =>{
				note.slideUp();
				console.log(response);
				// this.count--;
				if(response.noteCount <= (universityData.noteLimit -1) ){
					$(".note-limit-message").removeClass("active");
				}
			},
			error: (response) =>{
				console.log(response);
			},

		});
	}
	editNote(e){
		console.log("isEditting")
		var note = $(e.target).parents("li");
		var noteID = note.attr('id');
		var str = note.find(".edit-note").text();
		var isEdit = str.includes("Edit");
		// this.isEditting = false;

		if(!this.isEditting && isEdit){
			this.prevTitle = note.find(".note-title-field").val();
			this.prevBody = note.find(".note-body-field").text();
			note.find(".note-title-field, .note-body-field").removeAttr("readonly").addClass("note-active-field");
			note.find(".note-title-field").focus();	
			note.find(".update-note").addClass("update-note--visible");
			note.find(".edit-note").html(`<i class="fa fa-times"></i> Cancel`);
			this.isEditting = true;
		}
		else if(!isEdit){
			// revert back to read only
			note.find(".note-title-field").val(this.prevTitle);
			note.find(".note-body-field").val(this.prevBody);
			note.find(".note-title-field, .note-body-field").removeClass("note-active-field").prop('readonly', true);
			note.find(".update-note").removeClass("update-note--visible");
			note.find(".edit-note").html(`<i class="fa fa-pencil"></i> Edit`);
			this.isEditting = false;
		}

	}

	updateNote(e){
		var note = $(e.target).parents("li");
		var noteID = note.attr('id');
		$.ajax({
			method: "POST",
			url: universityData.root_url + '/wp-json/wp/v2/note/' + noteID,
			data: {
				title: note.find(".note-title-field").val(),
				content: note.find(".note-body-field").val(),
			},
			beforeSend: function ( xhr ) {
				xhr.setRequestHeader( 'X-WP-Nonce', universityData.nonce );
			},
			success : function( response ) {
				// revert back to read only
				note.find(".note-title-field, .note-body-field").removeClass("note-active-field").prop('readonly', true);
				note.find(".update-note").removeClass("update-note--visible");
				note.find(".edit-note").html(`<i class="fa fa-pencil"></i> Edit`);
				console.log(response);
			}
		});
		this.isEditting = false;
	}
	submitNote(){ //aka create new note
		if(!$(".new-note-title").val() == ""){
			$.ajax({
				method: "POST",
				url: universityData.root_url + '/wp-json/wp/v2/note/',
				data: {
					title: $(".new-note-title").val(),
					content: $(".new-note-body").val(),
					type: 'note',
					status: 'publish',
				},
				beforeSend: function ( xhr ) {
					xhr.setRequestHeader( 'X-WP-Nonce', universityData.nonce );
				},
				success : function( response ) {
					var noteID = response.id;
					var title = $(".new-note-title").val();
					var content = $(".new-note-body").val();
					$(".new-note-title").val("");
					$(".new-note-body").val("");
					$("#my-notes").prepend(`
						<li hidden id="${noteID}">
						<input readonly class="note-title-field" value="${title}">
						<span class="edit-note" id = "new-edit"><i class="fa fa-pencil"></i> Edit</span>
						<span class="delete-note" id = "new-delete"><i class="fa fa-trash-o"></i> Delete</span>
						<span class="share-note"><i class="fa fa-share"></i> Share</span>
						<textarea readonly class="note-body-field">${content}</textarea>
						<span class="update-note btn btn--blue btn--small"><i class="fa fa-arrow-right"></i> Save</span>
						</li>

						`);
					$(`#${noteID}`).slideToggle('slow');
					$(".alert").html("");
					// this.count++;

					console.log(response);

					console.log(noteID);
				// revert back to read only
				
			},
			error : function(response){
				if(response.responseText.includes("You have reached your note limit")){

					$(".note-limit-message").addClass("active");

				}
				console.log(response);
				
			}
		});


		// $("#new-delete").on("click", this.deleteNote.bind(this));
		// $("#new-edit").on("click", this.editNote.bind(this));

	}
	else if($(".new-note-title").val() == ""){
		$(".alert").html("  *Title is required");
	}

}

}
export default Notes;