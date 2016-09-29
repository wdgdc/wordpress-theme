<div class="kitchen-sink">
	<p>This is the kitchen sink:</p>

	<hr>

	<p>Headings:</p>
	<h1>Heading 1</h1>
	<h2>Heading 2</h2>
	<h3>Heading 3</h3>
	<h4>Heading 4</h4>
	<h5>Heading 5</h5>
	<h6>Heading 6</h6>

	<hr>

	<h2>Text-level semantics</h2>
	<p hidden>This should be hidden in all browsers, apart from IE6</p>
	<p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et m. Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et m. Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et m.</p>
	<p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et m. Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et m. Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et m.</p>
	<address>Address: somewhere, world</address>

	<hr>

	<p>
		The <a href="#">a element</a> example<br>
		The <abbr>abbr element</abbr> and <abbr title="Title text">abbr element with title</abbr> examples<br>
		The <b>b element</b> example<br>
		The <cite>cite element</cite> example<br>
		The <code>code element</code> example<br>
		The <del>del element</del> example<br>
		The <dfn>dfn element</dfn> and <dfn title="Title text">dfn element with title</dfn> examples<br>
		The <em>em element</em> example<br>
		The <i>i element</i> example<br>
		The img element <img src="http://placehold.it/16x16" alt=""> example<br>
		The <ins>ins element</ins> example<br>
		The <kbd>kbd element</kbd> example<br>
		The <mark>mark element</mark> example<br>
		The <q>q element <q>inside</q> a q element</q> example<br>
		The <s>s element</s> example<br>
		The <samp>samp element</samp> example<br>
		The <small>small element</small> example<br>
		The <span>span element</span> example<br>
		The <strong>strong element</strong> example<br>
		The <sub>sub element</sub> example<br>
		The <sup>sup element</sup> example<br>
		The <u>u element</u> example<br>
		The <var>var element</var> example
	</p>

	<hr>

	<h2>Embedded content</h2>

	<h3>Audio</h3>
	<audio controls></audio>
	<audio></audio>

	<h3>Image</h3>
	<img src="http://placehold.it/100x100" alt="">
	<a href="#"><img src="http://placehold.it/100x100" alt=""></a>

	<h3>SVG</h3>
	<svg width="100px" height="100px">
			<circle cx="100" cy="100" r="100" fill="#ff0000" />
	</svg>

	<h3>Video</h3>
	<video controls></video>
	<video></video>

	<hr>

	<h2>Grouping content</h2>
	<p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et m.</p>

	<h3>Preformatted text</h3>
	<pre>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et me.</pre>
	<pre><code>&lt;html>
&lt;head>
&lt;/head>
&lt;body>
	&lt;div class="main"> &lt;div>
&lt;/body>
&lt;/html></code></pre>

	<h3>Blockquotes</h3>
	<blockquote>
			<p>Some sort of famous witty quote marked up with a &lt;blockquote> and a child &lt;p> element.</p>
	</blockquote>
	<blockquote>Even better philosophical quote marked up with just a &lt;blockquote> element.</blockquote>

	<h3>Ordered list</h3>
	<ol>
		<li>list item 1</li>
		<li>list item 1
			<ol>
				<li>list item 2</li>
				<li>list item 2
					<ol>
						<li>list item 3</li>
						<li>list item 3</li>
					</ol>
				</li>
				<li>list item 2</li>
				<li>list item 2</li>
			</ol>
		</li>
		<li>list item 1</li>
		<li>list item 1</li>
	</ol>

	<h3>Unordered list</h3>
	<ul>
		<li>list item 1</li>
		<li>list item 1
			<ul>
				<li>list item 2</li>
				<li>list item 2
					<ul>
						<li>list item 3</li>
						<li>list item 3</li>
					</ul>
				</li>
				<li>list item 2</li>
				<li>list item 2</li>
			</ul>
		</li>
		<li>list item 1</li>
		<li>list item 1</li>
	</ul>

	<h3>Description list</h3>
	<dl>
		<dt>Description name</dt>
		<dd>Description value</dd>
		<dt>Description name</dt>
		<dd>Description value</dd>
		<dd>Description value</dd>
		<dt>Description name</dt>
		<dt>Description name</dt>
		<dd>Description value</dd>
	</dl>

	<h3>Figure</h3>
	<figure>
			<img src="http://placehold.it/400x200" alt="">
			<figcaption>Figcaption content</figcaption>
	</figure>

	<hr>

	<h2>Tables</h2>
	<table>
		<caption>Jimi Hendrix - albums</caption>
		<thead>
			<tr>
				<th>Album</th>
				<th>Year</th>
				<th>Price</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td>Are You Experienced</td>
				<td>1967</td>
				<td>$10.00</td>
			</tr>
			<tr>
				<td>Axis: Bold as Love</td>
				<td>1967</td>
				<td>$12.00</td>
			</tr>
			<tr>
				<td>Electric Ladyland</td>
				<td>1968</td>
				<td>$10.00</td>
			</tr>
			<tr>
				<td>Band of Gypsys</td>
				<td>1970</td>
				<td>$12.00</td>
			</tr>
		</tbody>
		<tfoot>
			<tr>
				<td colspan="3">More information goes here</th>
			</tr>
		</tfoot>
	</table>

	<hr>

	<h2>Forms</h2>
	<form>
		<fieldset>
			<legend>Inputs as descendents of labels (form legend). This doubles up as a long legend that can test word wrapping.</legend>
			<p><label>Text input <input type="text" value="default value that goes on and on without stopping or punctuation"></label></p>
			<p><label>Email input <input type="email"></label></p>
			<p><label>Search input <input type="search"></label></p>
			<p><label>Tel input <input type="tel"></label></p>
			<p><label>URL input <input type="url" placeholder="http://"></label></p>
			<p><label>Password input <input type="password" value="password"></label></p>
			<p><label>File input <input type="file"></label></p>
			<p><label>Progress bar <progress value="22" max="100"></progress></label></p>

			<p><label>Radio input <input type="radio" name="rad"></label></p>
			<p><label>Checkbox input <input type="checkbox"></label></p>
			<p><label><input type="radio" name="rad"> Radio input</label></p>
			<p><label><input type="checkbox"> Checkbox input</label></p>

			<p><label>Select field <select><option>Option 01</option><option>Option 02</option></select></label></p>
			<p><label>Textarea <textarea cols="30" rows="5" >Textarea text</textarea></label></p>
		</fieldset>

		<fieldset>
			<legend>Inputs as siblings of labels</legend>
			<p><label for="ic">Color input</label> <input type="color" id="ic" value="#000000"></p>
			<p><label for="in">Number input</label> <input type="number" id="in" min="0" max="10" value="5"></p>
			<p><label for="ir">Range input</label> <input type="range" id="ir" value="10"></p>
			<p><label for="idd">Date input</label> <input type="date" id="idd" value="1970-01-01"></p>
			<p><label for="idm">Month input</label> <input type="month" id="idm" value="1970-01"></p>
			<p><label for="idw">Week input</label> <input type="week" id="idw" value="1970-W01"></p>
			<p><label for="idt">Datetime input</label> <input type="datetime" id="idt" value="1970-01-01T00:00:00Z"></p>
			<p><label for="idtl">Datetime-local input</label> <input type="datetime-local" id="idtl" value="1970-01-01T00:00"></p>
			<p><label for="irb">Radio input</label> <input type="radio" id="irb" name="rad"></p>
			<p><label for="icb">Checkbox input</label> <input type="checkbox" id="icb"></p>
			<p><input type="radio" id="irb2" name="rad"> <label for="irb2">Radio input</label></p>
			<p><input type="checkbox" id="icb2"> <label for="icb2">Checkbox input</label></p>
			<p><label for="s">Select field</label> <select id="s"><option>Option 01</option><option>Option 02</option></select></p>
			<p><label for="t">Textarea</label> <textarea id="t" cols="30" rows="5" >Textarea text</textarea></p>
		</fieldset>

		<fieldset>
			<legend>Clickable inputs and buttons</legend>
			<p><button type="reset">Reset</button></p>
			<p><button type="button">Button</button></p>
			<p><button type="submit">Submit</button></p>
			<p><button type="submit" disabled>Disabled</button></p>
		</fieldset>
	</form>
</div>
