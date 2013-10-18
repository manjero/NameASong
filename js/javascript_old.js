var ajaxObject = false;
var submitGet;
var shareFunc;

var round_ID;

var vs_round_ID = false;

YUI().use('event-focus', 'json', 'model', 'model-list', 'view', function (Y) {
	var songTitleObj = Y.one('#title');
	//var songCounter = Y.one('#counter');
	var wordId;
	
	/*function startCounter(num){
		var iterations = num;
		var interval;
		
		function count(){
			songCounter.setHTML("(" + iterations + ")");
			if(--iterations == 0){
				var urlForGet = "http://www.ishahar.co.il/yahoo/check.php?word_ID=" + wordId;
    			var answers = Y.all('.todo-view');
    			
				clearInterval(interval);
    			    	
		    	answers.each(function () {
		    		if(this.get('text') == '' || this.get('text') == null){}
		    		else urlForGet += "&arr[]="+Y.Lang.trim(this.get('text'));
				});
				
				doAjaxQuery(urlForGet,false);
			}
		}
		
		interval = setInterval(function(){count(num);},1000);
	}*/
	
	function changeWord(){
		var urlForGet = "http://www.ishahar.co.il/yahoo/get.php?user_ID=" + user_ID;

        if(vs_round_ID) 
        {
            vs = true;
            urlForGet += '&round_ID=' + vs_round_ID;
        }
		doAjaxQuery(urlForGet,true);
	}
	
	function doAjaxQuery(url, starting) {
		ajaxObject = false;
		if (window.XMLHttpRequest) {// if we're on Gecko (Firefox etc.), KHTML/WebKit (Safari/Konqueror) and IE7
			ajaxObject = new XMLHttpRequest();
			// create our new Ajax object
			if (ajaxObject.overrideMimeType) {// older Mozilla-based browsers need some extra help
				ajaxObject.overrideMimeType('text/xml');
			}
		} else if (window.ActiveXObject) {// and now for IE6
			try {// IE6 has two methods of calling the object, typical!
				ajaxObject = new ActiveXObject("Msxml2.XMLHTTP");
				// create the ActiveX control
			} catch (e) {// catch the error if creation fails
				try {// try something else
					ajaxObject = new ActiveXObject("Microsoft.XMLHTTP");
					// create the ActiveX control (using older XML library)
				} catch (e) {
				} // catch the error if creation fails
			}
		}
		if (!ajaxObject) {// if the object doesn't work
			// for some reason it hasn't worked, so show an error
			alert('Sorry, your browser seems to not support this functionality.');
			return false;
			// exit out of this function
		}
		ajaxObject.onreadystatechange = (starting==true)?ajaxStateChangeStart:ajaxStateChangeResult;
		// when the ready state changes, run this function
		// DO NOT ADD THE () AT THE END, NO PARAMETERS ALLOWED!
		ajaxObject.open('GET', url, true);
		// open the query to the server
		ajaxObject.send(null);
		// close the query
		
		// and now we wait until the readystate changes, at which point
		// ajaxResponse(); is executed
		
		return true;
	}// end function doAjaxQuery
	
	function ajaxStateChangeStart(){
		// N.B. - in making your own functions like this, please note
		// that you cannot have ANY PARAMETERS for this type of function!!
		if (ajaxObject.readyState == 4) {// if ready state is 4 (the page is finished loading)
			if (ajaxObject.status == 200) {// if the status code is 200 (everything's OK)
				// here is where we will do the processing
				/*var s=document.createElement('script'); // create script element
				s.src= ajaxObject.responseText;*/
				/*var jsondata=eval(ajaxObject.responseText); //retrieve result as an JavaScript object
				var entries=jsondata.items;*/
				
    			var jasonObj = JSON.parse(ajaxObject.responseText);
    			wordId = jasonObj.word_ID;
                if(jasonObj.round_ID)
                    round_ID = jasonObj.round_ID;

				songTitleObj.setHTML(jasonObj.word_text);
				//startCounter(30);
				//document.body.appendChild(s); // Send the response url to the callback function: "_cb_findItemsAdvancedResponse"
			}// end if
			else {// if the status code is anything else (bad news)
				alert('There was an error. HTTP error code ' + ajaxObject.status.toString() + '.');
				return;
				// exit
			}
		} // end if
	}
	
	submitGet = function(){
		alert("submitGet");
		var urlForGet = "http://www.ishahar.co.il/yahoo/check.php?word_ID=" + wordId;
        if(round_ID > 0) urlForGet += '&round_ID=' + round_ID;
		var answers = Y.all('.todo-view');
		
		answers.each(function () {
    		if(this.get('text') == '' || this.get('text') == null){}
    		else urlForGet += "&arr[]="+Y.Lang.trim(this.get('text'));
		});
		
		doAjaxQuery(urlForGet,false);
	};
	
	function ajaxStateChangeResult(){
		// N.B. - in making your own functions like this, please note
		// that you cannot have ANY PARAMETERS for this type of function!!
		
		if (ajaxObject.readyState == 4) {// if ready state is 4 (the page is finished loading)
			if (ajaxObject.status == 200) {// if the status code is 200 (everything's OK)
				// here is where we will do the processing
				/*var s=document.createElement('script'); // create script element
				s.src= ajaxObject.responseText;*/
				/*var jsondata=eval(ajaxObject.responseText); //retrieve result as an JavaScript object
				var entries=jsondata.items;*/
				alert(ajaxObject.responseText);
				
    			var jasonObj = JSON.parse(ajaxObject.responseText);
    			
    			
    			/*songId = asonObj.word_ID;
				songTitleObj.setHTML(jasonObj.word_text);
				startCounter(30);*/
				//document.body.appendChild(s); // Send the response url to the callback function: "_cb_findItemsAdvancedResponse"
			}// end if
			else {// if the status code is anything else (bad news)
				alert('There was an error. HTTP error code ' + ajaxObject.status.toString() + '.');
				return;
				// exit
			}
		} // end if
	}
	
	changeWord();
	
	/*Y.one('#find').on('click', function () {
		songTitle = songTitleObj.get('text');
    	var urlForGet = "http://www.ishahar.co.il/yahoo/index.php?songTitle=" + songTitle;
    	var answers = Y.all('.todo-view');
    	
    	//alert(songTitle);
    	answers.each(function () {
    		if(this.get('text') == '' || this.get('text') == null){}
    		else urlForGet += "&arr[]="+Y.Lang.trim(this.get('text'));
    		//alert(this.get('text'));
		});
		
		//alert(urlForGet);
		doAjaxQuery(urlForGet, 'false');
	 });*/

	var TodoAppView, TodoList, TodoModel, TodoView;
	
	// -- Model --------------------------------------------------------------------
	
	// The TodoModel class extends Y.Model and customizes it to use a localStorage
	// sync provider (the source for that is further below) and to provide
	// attributes and methods useful for todo items.
	
	TodoModel = Y.TodoModel = Y.Base.create('todoModel', Y.Model, [], {
	    // This tells the Model to use a localStorage sync provider (which we'll
	    // create below) to save and load information about a todo item.
	    sync: LocalStorageSync('todo'),
	
	    // This method will toggle the `done` attribute from `true` to `false`, or
	    // vice versa.
	    toggleDone: function () {
	        this.set('done', !this.get('done')).save();
	    }
	}, {
	    ATTRS: {
	        // Indicates whether or not this todo item has been completed.
	        done: {value: false},
	
	        // Contains the text of the todo item.
	        text: {value: ''}
	    }
});


// -- ModelList ----------------------------------------------------------------

// The TodoList class extends Y.ModelList and customizes it to hold a list of
// TodoModel instances, and to provide some convenience methods for getting
// information about the todo items in the list.

TodoList = Y.TodoList = Y.Base.create('todoList', Y.ModelList, [], {
    // This tells the list that it will hold instances of the TodoModel class.
    model: TodoModel,

    // This tells the list to use a localStorage sync provider (which we'll
    // create below) to load the list of todo items.
    sync: LocalStorageSync('todo'),

    // Returns an array of all models in this list with the `done` attribute
    // set to `true`.
    done: function () {
        return this.filter(function (model) {
            return model.get('done');
        });
    },

    // Returns an array of all models in this list with the `done` attribute
    // set to `false`.
    remaining: function () {
        return this.filter(function (model) {
            return !model.get('done');
        });
    }
});
	
	
// -- Todo App View ------------------------------------------------------------

// The TodoAppView class extends Y.View and customizes it to represent the
// main shell of the application, including the new item input field and the
// list of todo items.
//
// This class also takes care of initializing a TodoList instance and creating
// and rendering a TodoView instance for each todo item when the list is
// initially loaded or reset.

TodoAppView = Y.TodoAppView = Y.Base.create('todoAppView', Y.View, [], {
    // This is where we attach DOM events for the view. The `events` object is a
    // mapping of selectors to an object containing one or more events to attach
    // to the node(s) matching each selector.
    events: {
        // Handle <enter> keypresses on the "new todo" input field.
        '#new-todo': {keypress: 'createTodo'},

        // Clear all completed items from the list when the "Clear" link is
        // clicked.
        '.todo-clear': {click: 'clearDone'},

        // Add and remove hover states on todo items.
        '.todo-item': {
            mouseover: 'hoverOn',
            mouseout : 'hoverOff'
        }
    },

    // The `template` property is a convenience property for holding a
    // template for this view. In this case, we'll use it to store the
    // contents of the #todo-stats-template element, which will serve as the
    // template for the statistics displayed at the bottom of the list.
    template: Y.one('#todo-stats-template').getHTML(),

    // The initializer runs when a TodoAppView instance is created, and gives
    // us an opportunity to set up the view.
    initializer: function () {
        // Create a new TodoList instance to hold the todo items.
        var list = this.todoList = new TodoList();

        // Update the display when a new item is added to the list, or when the
        // entire list is reset.
        list.after('add', this.add, this);
        list.after('reset', this.reset, this);

        // Re-render the stats in the footer whenever an item is added, removed
        // or changed, or when the entire list is reset.
        list.after(['add', 'reset', 'remove', 'todoModel:doneChange'],
                this.render, this);

        // Load saved items from localStorage, if available.
        list.load();
    },

    // The render function is called whenever a todo item is added, removed, or
    // changed, thanks to the list event handler we attached in the initializer
    // above.
    render: function () {
        var todoList = this.todoList,
            stats    = this.get('container').one('#todo-stats'),
            numRemaining, numDone;

        // If there are no todo items, then clear the stats.
        if (todoList.isEmpty()) {
            stats.empty();
            return this;
        }

        // Figure out how many todo items are completed and how many remain.
        numDone      = todoList.done().length;
        numRemaining = todoList.remaining().length;

        // Update the statistics.
        stats.setHTML(Y.Lang.sub(this.template, {
            numDone       : numDone,
            numRemaining  : numRemaining,
            doneLabel     : numDone === 1 ? 'task' : 'tasks',
            remainingLabel: numRemaining === 1 ? 'task' : 'answers'
        }));

        // If there are no completed todo items, don't show the "Clear
        // completed items" link.
        if (!numDone) {
            stats.one('.todo-clear').remove();
        }

        return this;
    },

    // -- Event Handlers -------------------------------------------------------

    // Creates a new TodoView instance and renders it into the list whenever a
    // todo item is added to the list.
    add: function (e) {
        var view = new TodoView({model: e.model});

        this.get('container').one('#todo-list').append(
            view.render().get('container')
        );
    },

    // Removes all finished todo items from the list.
    clearDone: function (e) {
        var done = this.todoList.done();

        e.preventDefault();

        // Remove all finished items from the list, but do it silently so as not
        // to re-render the app view after each item is removed.
        this.todoList.remove(done, {silent: true});

        // Destroy each removed TodoModel instance.
        Y.Array.each(done, function (todo) {
            // Passing {remove: true} to the todo model's `destroy()` method
            // tells it to delete itself from localStorage as well.
            todo.destroy({remove: true});
        });

        // Finally, re-render the app view.
        this.render();
    },

    // Creates a new todo item when the enter key is pressed in the new todo
    // input field.
    createTodo: function (e) {
        var inputNode, value;

        if (e.keyCode === 13) { // enter key
            inputNode = this.get('inputNode');
            value     = Y.Lang.trim(inputNode.get('value'));

            if (!value) { return; }

            // This tells the list to create a new TodoModel instance with the
            // specified text and automatically save it to localStorage in a
            // single step.
            this.todoList.create({text: value});

            inputNode.set('value', '');
        }
    },

    // Turns off the hover state on a todo item.
    hoverOff: function (e) {
        e.currentTarget.removeClass('todo-hover');
    },

    // Turns on the hover state on a todo item.
    hoverOn: function (e) {
        e.currentTarget.addClass('todo-hover');
    },

    // Creates and renders views for every todo item in the list when the entire
    // list is reset.
    reset: function (e) {
        var fragment = Y.one(Y.config.doc.createDocumentFragment());

        Y.Array.each(e.models, function (model) {
            var view = new TodoView({model: model});
            fragment.append(view.render().get('container'));
        });

        this.get('container').one('#todo-list').setHTML(fragment);
    }
}, {
    ATTRS: {
        // The container node is the wrapper for this view. All the view's
        // events will be delegated from the container. In this case, the
        // #todo-app node already exists on the page, so we don't need to create
        // it.
        container: {
            valueFn: function () {
                return '#todo-app';
            }
        },

        // This is a custom attribute that we'll use to hold a reference to the
        // "new todo" input field.
        inputNode: {
            valueFn: function () {
                return Y.one('#new-todo');
            }
        }
    }
});


// -- Todo item view -----------------------------------------------------------

// The TodoView class extends Y.View and customizes it to represent the content
// of a single todo item in the list. It also handles DOM events on the item to
// allow it to be edited and removed from the list.

TodoView = Y.TodoView = Y.Base.create('todoView', Y.View, [], {
    // This customizes the HTML used for this view's container node.
    containerTemplate: '<li class="todo-item"/>',

    // Delegated DOM events to handle this view's interactions.
    events: {
        // Toggle the "done" state of this todo item when the checkbox is
        // clicked.
        //'.todo-checkbox': {click: 'toggleDone'},

        // When the text of this todo item is clicked or focused, switch to edit
        // mode to allow editing.
        '.todo-content': {
            click: 'edit',
            focus: 'edit'
        },

        // On the edit field, when enter is pressed or the field loses focus,
        // save the current value and switch out of edit mode.
        '.todo-input'   : {
            blur    : 'save',
            keypress: 'enter'
        },

        // When the remove icon is clicked, delete this todo item.
        '.todo-remove': {click: 'remove'}
    },

    // The template property holds the contents of the #todo-item-template
    // element, which will be used as the HTML template for each todo item.
    template: Y.one('#todo-item-template').getHTML(),

    initializer: function () {
        // The model property is set to a TodoModel instance by TodoAppView when
        // it instantiates this TodoView.
        var model = this.get('model');

        // Re-render this view when the model changes, and destroy this view
        // when the model is destroyed.
        model.after('change', this.render, this);

        model.after('destroy', function () {
            this.destroy({remove: true});
        }, this);
    },

    render: function () {
        var container = this.get('container'),
            model     = this.get('model'),
            done      = model.get('done');

        container.setHTML(Y.Lang.sub(this.template, {
            checked: done ? 'checked' : '',
            text   : model.getAsHTML('text')
        }));

        container[done ? 'addClass' : 'removeClass']('todo-done');
        this.set('inputNode', container.one('.todo-input'));

        return this;
    },

    // -- Event Handlers -------------------------------------------------------

    // Toggles this item into edit mode.
    edit: function () {
        this.get('container').addClass('editing');
        this.get('inputNode').focus();
    },

    // When the enter key is pressed, focus the new todo input field. This
    // causes a blur event on the current edit field, which calls the save()
    // handler below.
    enter: function (e) {
        if (e.keyCode === 13) { // enter key
            Y.one('#new-todo').focus();
        }
    },

    // Removes this item from the list.
    remove: function (e) {
        e.preventDefault();

        this.constructor.superclass.remove.call(this);
        this.get('model').destroy({'delete': true});
    },

    // Toggles this item out of edit mode and saves it.
    save: function () {
        this.get('container').removeClass('editing');
        this.get('model').set('text', this.get('inputNode').get('value')).save();
    },

    // Toggles the `done` state on this item's model.
    toggleDone: function () {
        this.get('model').toggleDone();
    }
});


// -- localStorage Sync Implementation -----------------------------------------

// This is a simple factory function that returns a `sync()` function that can
// be used as a sync layer for either a Model or a ModelList instance. The
// TodoModel and TodoList instances above use it to save and load items.

function LocalStorageSync(key) {
    var localStorage;

    if (!key) {
        Y.error('No storage key specified.');
    }

    if (Y.config.win.localStorage) {
        localStorage = Y.config.win.localStorage;
    }

    // Try to retrieve existing data from localStorage, if there is any.
    // Otherwise, initialize `data` to an empty object.
    var data = Y.JSON.parse((localStorage && localStorage.getItem(key)) || '{}');

    // Delete a model with the specified id.
    function destroy(id) {
        var modelHash;

        if ((modelHash = data[id])) {
            delete data[id];
            save();
        }

        return modelHash;
    }

    // Generate a unique id to assign to a newly-created model.
    function generateId() {
        var id = '',
            i  = 4;

        while (i--) {
            id += (((1 + Math.random()) * 0x10000) | 0)
                    .toString(16).substring(1);
        }

        return id;
    }

    // Loads a model with the specified id. This method is a little tricky,
    // since it handles loading for both individual models and for an entire
    // model list.
    //
    // If an id is specified, then it loads a single model. If no id is
    // specified then it loads an array of all models. This allows the same sync
    // layer to be used for both the TodoModel and TodoList classes.
    function get(id) {
        return id ? data[id] : Y.Object.values(data);
    }

    // Saves the entire `data` object to localStorage.
    function save() {
        localStorage && localStorage.setItem(key, Y.JSON.stringify(data));
    }

    // Sets the id attribute of the specified model (generating a new id if
    // necessary), then saves it to localStorage.
    function set(model) {
        var hash        = model.toJSON(),
            idAttribute = model.idAttribute;

        if (!Y.Lang.isValue(hash[idAttribute])) {
            hash[idAttribute] = generateId();
        }

        data[hash[idAttribute]] = hash;
        save();

        return hash;
    }

    // Returns a `sync()` function that can be used with either a Model or a
    // ModelList instance.
    return function (action, options, callback) {
        // `this` refers to the Model or ModelList instance to which this sync
        // method is attached.
        var isModel = Y.Model && this instanceof Y.Model;

        switch (action) {
        case 'create': // intentional fallthru
        case 'update':
            callback(null, set(this));
            return;

        case 'read':
            callback(null, get(isModel && this.get('id')));
            return;

        case 'delete':
            callback(null, destroy(isModel && this.get('id')));
            return;
        }
    };
}


	// -- Start your engines! ------------------------------------------------------
	
	// Finally, all we have to do is instantiate a new TodoAppView to set everything
	// in motion and bring our todo list into existence.
	new TodoAppView();
});

shareFunc = function()
{
    window.open('http://www.facebook.com/sharer/sharer.php?u=http://www.ishahar.co.il/yahoo/game.php?round_ID=' + round_ID + '&t=lets Play!', 'facebook_share', 'height=320, width=640, toolbar=no, menubar=no, scrollbars=no, resizable=no, location=no, directories=no, status=no');
}

window.onload = function() {
	var myCountdown2 = new Countdown({
				time : 30, 
				width:100, 
				height:80,
				target:"timer",
				onComplete: submitGet,
				rangeHi:"second"	// <- no comma on last item!
	});		
};