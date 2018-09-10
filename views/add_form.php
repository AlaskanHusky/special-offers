<div class="offer-form">
    <h2>Adding Special Offer</h2>
    <form action="#" method="post" enctype="multipart/form-data">
        <div class="offer-prop">
            <label for="offer-title">Offer Title</label>
            <input type="text" name="offer-title" placeholder="Enter offer title here" required>
        </div>
        <div class="offer-prop">
            <label for="offer-desc">Description</label>
            <textarea rows="6" cols="50" name="offer-desc" placeholder="Enter offer description here"></textarea>
        </div>
        <div class="offer-prop">
            <label for="offer-cat">Category</label>
            <input type="text" name="offer-cat" placeholder="Enter offer category here" required>
        </div>
        <div class="offer-prop">
            <label for="offer-reg-price">Regular Price</label>
            <input type="text" name="offer-reg-price" placeholder="Enter offer regular price here" required>
        </div>
        <div class="offer-prop">
            <label for="offer-spec-price">Special Price</label>
            <input type="text" name="offer-spec-price" placeholder="Enter offer special price here" required>
        </div>
        <div class="offer-prop">
            <label for="offer-date">Offer Date</label>
            <input type="text" name="offer-date" placeholder="Enter offer date here (e.g. yyyy-mm-dd hh:mm)" required>
        </div>
        <div class="offer-prop">
            <label for="offer-image">Offer Image</label>
            <input type="file" name="offer-image" accept=".jpg, .jpeg, .png">
        </div>
        <input type="submit" name="specoff" value="Add offer"/>
    </form>
</div>