import $ from 'jquery';

class Search{
	//1. describe and initiate object
	constructor(){
		this.addSearchHTML();
		this.searchOverlay = $(".search-overlay");
		this.openButton = $(".js-search-trigger");
		this.closeButton = $(".search-overlay__close");
		this.isOpenOverlay = false;
		this.isLoading = false;
		this.searchField = $("#search-term");
		this.typingTimer;
		this.resultsDiv = $("#search-overlay__results");
		this.prevValue = "";
		this.events();

	}

	//2. Events
	events() {
		this.openButton.on("click", this.openOverlay.bind(this));
		this.closeButton.on("click", this.closeOverlay.bind(this));
		window.addEventListener("keydown", this.checkKeyPress.bind(this), false);
		this.searchField.on("keyup", this.startTimer.bind(this));
	}

	//3. Methods
	checkKeyPress(key){
		if(key.keyCode == 83 && !this.isOpenOverlay && !$("input, textarea").is(':focus')){
			this.openOverlay();
			// console.log(key.keyCode);
		}
		else if(key.keyCode == 27 && this.isOpenOverlay){
			this.closeOverlay();
			// console.log(key.keyCode);
		}
	}
	startTimer(key){
		if(this.searchField.val() != this.prevValue){
			clearTimeout(this.typingTimer);
			if(this.searchField.val()){
				if(!this.isLoading){
					this.resultsDiv.html('<div class="spinner-loader"></div>');
					this.isLoading = true;
				}
				this.typingTimer = setTimeout(this.getResults.bind(this), 750);
				//do something
			}
			else{
				this.resultsDiv.html("");
				this.isLoading = false;
			}
		}
		this.prevValue = this.searchField.val();

	}
	getResults(){
		if(this.searchField.val() != ""){
			$.getJSON(universityData.root_url + '/wp-json/university/v1/search?term=' + this.searchField.val(), items=>{
				var posts = items['generalInfo'];
				var programs = items['programs'];
				var professors = items['professors'];
				var campuses = items['campuses'];
				var eventsLocal = items['events'];

				this.resultsDiv.html(
					`
					<div class="row">
					<div class="one-third">
					<h3 class = "search-overlay__section-title"> General Information </h3>
					${posts.length ?
						`<ul class="link-list min-list">
							${posts.map(post=> `<li><a href="${post['permalink']}">${post['title']}</a>
							${post['author']?`by ${post['author']}` : ''} 
							</li>`).join('')}
							</ul>
							`:
							`
							<p>No general information matches that search.</p>
							`
					}

					</div>
					<div class="one-third">

					<h3 class = "search-overlay__section-title"> Programs </h3>
					${programs.length ?
						`<ul class="link-list min-list">
						${programs.map(post=> `<li><a href="${post['permalink']}">${post['title']}</a></li>`).join('')}
						</ul>
						`:
						`
						<p>No programs match that search. <a href="${universityData.root_url + "/programs"}">View all programs </a></p>
						`
					}


					<h3 class = "search-overlay__section-title"> Professors </h3>
					${professors.length ?
						`<ul class="professor-cards">
						${professors.map(post=> `
							<li class="professor-card__list-item">
			                    <a class= "professor-card" href="${post['permalink']}">
			                        <img class="professor-card__image" src="${post['imageURL']}"></img>
			                        <span class="professor-card__name">${post['title']}</span>
			                    </a>
                			</li>
							`).join('')}
                		</ul>
						`:
						`
						<p>No professors match that search.</p>
						`
					}

					</div>
					<div class="one-third">

					<h3 class = "search-overlay__section-title"> Campuses </h3>
					${campuses.length ?
						`<ul class="link-list min-list">
						${campuses.map(post=> `<li><a href="${post['permalink']}">${post['title']}</a></li>`).join('')}
						</ul>
						`:
						`
						<p>No campuses match that search. <a href="${universityData.root_url + "/campuses"}">View all campuses </a></p>
						`
					}


					<h3 class = "search-overlay__section-title"> Events </h3>
					${eventsLocal.length ?
						eventsLocal.map(post=> `
							<div class="event-summary">
								<a class="event-summary__date t-center" href="${post['permalink']}">
									<span class="event-summary__month">${post['month']}</span>
									<span class="event-summary__day">${post['day']}</span>  
								</a>
								<div class="event-summary__content">
									<h5 class="event-summary__title headline headline--tiny"><a href="${post['permalink']}">${post['title']}</a></h5>
									<p>${post['excerpt']}<a href="${post['permalink']}" class="nu gray">Read more</a></p>

								</div>
							</div>
							`).join(''):
							`
							<p>No campuses match that search. <a href="${universityData.root_url + "/campuses"}">View all events </a></p>
							`
						}
						
						
					

					</div>

					</div>
					
					`);

			});

		}
		else{
			this.resultsDiv.html("");
		}
		this.isLoading = false;
	}
	getResultsTwo(){
		if(this.searchField.val() != ""){
			$.when(
				$.getJSON(universityData.root_url + '/wp-json/wp/v2/posts?search=' + this.searchField.val(), ()=>{}),
				$.getJSON(universityData.root_url + '/wp-json/wp/v2/pages?search=' + this.searchField.val(), ()=>{})
				).then((posts, pages)=>{
					var combinedResults = posts[0].concat(pages[0]);
					this.resultsDiv.html(
						`
						<h2 class = "search-overlay__section-title"> General Information </h2>
						${combinedResults.length ?
							`<ul class="link-list min-list">
							${combinedResults.map(post=> `<li><a href="${post.link}">${post.title.rendered}</a>
							${post.type == 'post'?`by ${post.authorName}` : ''} 
							</li>`).join('')}
							</ul>
							`:
							`
							<p>No general information match that search.</p>
							`
						}

						`);
				}, () => {
					this.resultsDiv.html("Unexpected Error Occured. Please try again later.");
				});
			}
			else{
				this.resultsDiv.html("");
			}
			this.isLoading = false;
		}

		openOverlay(){
			this.searchOverlay.addClass("search-overlay--active");
			$("body").addClass("body-no-scroll");
			this.isLoading = false;
			setTimeout(() => this.searchField.focus(), 301);
			this.isOpenOverlay = true;
			this.getResults();
			return false;

		}

		closeOverlay(){
		// document.getElementById("search-term").value = "";
		this.searchField.val('');
		this.searchOverlay.removeClass("search-overlay--active");
		$("body").removeClass("body-no-scroll");
		this.isOpenOverlay = false;
	}

	addSearchHTML(){
		$("body").append(`
			<div class="search-overlay">
			<div class="search-overlay__top">
			<div class="container">
			<i class="fa fa-search search-overlay__icon" aria-hidden = "true"></i>
			<input type="text" class="search-term" placeholder="What are you looking for?" id="search-term">
			<i class="fa fa-window-close search-overlay__close" aria-hidden = "true"></i>

			</div>
			</div>
			<div class="container">
			<div id="search-overlay__results"></div>
			</div>
			</div>
			`)
	}
	


}

export default Search;