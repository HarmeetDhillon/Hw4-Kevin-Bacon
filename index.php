<?php include("top.html"); ?>
<h1>The One Degree of Kevin Bacon</h1>
<p>Type in an actor's name to see if he/she was ever in a movie with Kevin Bacon!</p>
<p><img src="images\kevin_bacon.jpg" alt="Kevin Bacon" /></p>

<!-- Add film fields -->
<form action="add_film.php" method="get">
    <fieldset>
        <legend>Add a new film</legend>
        <div>
            <label>Name:</label>  <input name="mName" type="text" size="12" placeholder="movie name" /> 
        </div>
        <div>
            <label>Year:</label> <input name="mYear" type="text" size="12" placeholder="year" /> 
        </div> 
        <div>
            <label>Actor:</label>
            <input name="actFirstName" type="text" size="12" placeholder="First Name" /> 
            <input name="actLastName" type="text" size="12" placeholder="Last Name" /> 
        </div>
        <div>
            <label>Director:</label> <input name="dirFirstName" type="text" size="12" placeholder="First Name" /> 
            <input name="dirLastName" type="text" size="12" placeholder="Last Name" /> 
        </div>
        <div>
            <select name="movie_Genre"> 
                <option value="Action" selected="selected">Action</option>
                <option value="Adventure">Adventure</option>
                <option value="Animation">Animation</option>
                <option value="Comedy">Comedy</option>
                <option value="Crime">Crime</option>
                <option value="Documentary">Documentary</option>
                <option value="Drama">Drama</option>
                <option value="Family">Family</option>
                <option value="Fantasy">Fantasy</option>
                <option value="Horror">Horror</option>
                <option value="Musical">Musical</option>
                <option value="Mystery">Mystery</option>
                <option value="Romance">Romance</option>
                <option value="Sci-Fi">Sci-Fi</option>
                <option value="Short">Short</option>
                <option value="Thriller">Thriller</option>
                <option value="War">War</option>
                <option value="Western">Western</option>
            </select>
            <div>
                <input type="submit" name="addMovie" value="go" />
            </div>
        </div>
    </fieldset>
</form>

<?php include("bottom.html"); ?>
