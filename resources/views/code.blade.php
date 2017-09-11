@extends('layouts.template')
@section('content')
    <main id="main-page-content">
        <div class="row no-margin " id="content-inner">
            <div class="col s12">
                <div class="container grey-text text-darken-4 body" id="design_slide_1">
                    <div class="row no-margin">
                        <div class="col l12 s12">
                            <h3 class="cyan-text">Code Examples</h3>
                            <hr>
                            <p>
                                Coding isn't just my profession, it's also my passion. I have a huge array of wildly different projects
                                that I've been doing both at work and on my free time for fun. If what you see here doesn't sate you, feel
                                free to contact me. I legitimately love a challenge, if you want me to code something just for you, I'll do it.
                                <br><br>
                                Firstly, the code for this website: <a href="https://github.com/LynneKirsch/lynnekirschsite">https://github.com/LynneKirsch/lynnekirschsite</a>
                                <br><br>
                                This site is just a really simple Laravel site. In fact, thinking now Laravel was probably overkill for this website,
                                but I wanted to show that I can use pretty much any PHP framework comfortably.
                            </p>
                            <h5>Sylph | PHP Framework - Passion Project</h5>
                            <hr>
                            <p>
                                So Sylph is just something I'm doing in my free time when I'm bored, and it's probably not something that the
                                world really needs. I've used this a couple times for one - off websites as a favor. It's just a really quick way
                                for me to get a simple website up that has some CMS capabilities for friends.
                                <br><br>
                                It uses doctrine ORM for entity management, MySQL, ajax, quill editor, material frontend framework (like this site!),
                                symfony components and some other various things.
                                <br><br>
                                I really enjoy working on this project, it's just fun to see how simple and simultaneously robust I can make a site, and
                                someday being able to say that I developed my own complete framework that people use is my nerdy equivalent to being a rockstar.
                                <br><br>
                                Here's the code: <a href="https://github.com/LynneKirsch/Sylph">https://github.com/LynneKirsch/Sylph</a>
                            </p>
                            <h5>PHP MUD | Game - Passion Project</h5>
                            <hr>
                            <p>
                                At risk of exposing how incredibly nerdy I am, this project is basically a text-based version of Dungeons and Dragons, built in PHP and
                                rendered in a text area on a web page. It uses some pretty cool technology though, so despite how dorky it makes me look, I wanted to
                                include it here.
                                <br><br>
                                At the very core, we use Websockets to interact with the clients. On top of that, active record and sqlite to build a database. And
                                lots and lots of PHP code to achieve all the fun game aspects.
                                <br><br>
                                Someday I'd really like to finish this. It would just be cool to say I developed an entire game in a web-based language.
                                <br><br>
                                Here's the code (on its second iteration): <a href="https://github.com/LynneKirsch/phpmud2">https://github.com/LynneKirsch/phpmud2</a>
                            </p>
                            <h5>Various Code Examples</h5>
                            <hr>
                            <p>Oh yes, I integrated a syntax highlighter for you!</p>
                            <script>hljs.initHighlightingOnLoad();</script>
                            <ul class="collapsible" data-collapsible="accordion">
                                <li>
                                    <div class="collapsible-header">PHP - View Controller for Items</div>
                                    <div class="collapsible-body"><pre><code class="php6">

namespace TwCore\Controllers\View;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use TwCore\Controllers\Data\ItemData;
use TwCore\Controllers\Data\ShoppingCarts;
use TwCore\Controllers\Data\Users;
use TwCore\Model\CmsArea;
use TwCore\Model\ItemCleanUrl;

class ItemController extends TemplateController
{
    /**
     * Takes the item clean name from the URL and displays
     * the associated item.
     *
     * @param $context
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function displayItemFromClean($context)
    {
        $clean_name = $context['item_clean_name'];

        /* @var ItemCleanUrl $clean_url */
        $clean_url = $this->getEntityMgr()->getRepository(":ItemCleanUrl")->findOneBy([
            "item_clean_url" => $clean_name
        ]);

        return $this->displayItem($context, $clean_url->getItemTypeCode(), $clean_url->getItemId());
    }

    /**
     * Displays item based on a passed type_code and item_id
     * from the route, for backwards compatibility
     * @param $context
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function displayItemFromTypeCode($context)
    {
        $type_code = $context['type_code'];
        $item_id = $context['item_id'];

        return $this->displayItem($context, $type_code, $item_id);
    }

    /**
     * Takes type code and item id and builds the view
     *
     * @param $context
     * @param $type_code
     * @param $item_id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function displayItem($context, $type_code, $item_id)
    {
        $data['is_admin'] = false;

        if (is_a($this->getUser(), 'TwCore\Model\UserAdmin')) {
            $data['is_admin'] = true;
        }

        $item_data = new ItemData($this->getEntityMgr());
        $data['item'] = $item_data->getItemViewData($this->getUser(), $type_code, $item_id);

        // if the item is null it either doesn't exist or the user doesn't have permission
        if (is_null($data['item'])) {
            return new Response('Item not Found', Response::HTTP_NOT_FOUND);
        } else {
            $user_data_controller = new Users($this->getEntityMgr());
            $user = $this->getUser();
            if ($user_data_controller->userHasPermission($user, 'can_see_bulk_item_interface')) {
                $data['is_bulk_input'] = isset($data['item']['bulk_entry']) && $data['item']['display_mode'] == 'user_defined';
            } else {
                $data['is_bulk_input'] = false;
            }
            $data['days_to_ship'] = $this->getSiteOptionValue("days_to_ship");
            $context['render-context'] = $data;
            return $this->generateResponseFromRoute($context);
        }
    }

    /**
     * Takes bulk entry data from POST and loops through
     * to add items to cart.
     */
    public function parseBulkInput()
    {

        $filters = array(
            'quantity' => FILTER_SANITIZE_NUMBER_INT,
            'price_each' => FILTER_SANITIZE_STRING,
            'item_id' => FILTER_SANITIZE_NUMBER_INT,
            'size_id' => FILTER_SANITIZE_NUMBER_INT,
            'color_id' => FILTER_SANITIZE_NUMBER_INT,
            'item_type_code' => FILTER_SANITIZE_NUMBER_INT,
            'logo_id' => FILTER_SANITIZE_NUMBER_INT,
            'sku_quantity' => FILTER_SANITIZE_NUMBER_INT,
            'logo' => FILTER_SANITIZE_STRING,
            'location' => FILTER_SANITIZE_STRING,
            'color' => FILTER_SANITIZE_STRING,
            'size' => FILTER_SANITIZE_STRING,

        );

        $cart = new ShoppingCarts($this->getEntityMgr());
        $item_data = new ItemData($this->getEntityMgr());
        $item = $item_data->getItem(
            filter_input(INPUT_POST, "item_type_code", FILTER_SANITIZE_NUMBER_INT),
            filter_input(INPUT_POST, "item_id", FILTER_SANITIZE_NUMBER_INT)
        );

        $added = 0;
        $items = json_decode($_POST['items'], true);

        foreach ($items as $bulk_item) {
            $array = filter_var_array($bulk_item, $filters);

            if ($array['quantity'] > 0) {
                if (!$item->getIsLimitBySkuQuantity()
                    || ($item->getIsLimitBySkuQuantity() && $array['quantity'] <= $array['sku_quantity'])
                ) {
                    $added += $array['quantity'];

                    $cart->addItemToUsersShoppingCart(
                        $this->getUser(),
                        $item,
                        $array['quantity'] ?? 0,
                        $array['size_id'] ?? 0,
                        $array['color_id'] ?? 0,
                        $array['logo_id'] ?? 0,
                        $array['location_id'] ?? 0
                    );
                }
            }
        }

        $user_cart = $cart->getShoppingCartForUser($this->getUser());

        $response["added"] = $added;
        return new JsonResponse(
            [
                "added" => $added,
                "count" => $user_cart->getItemsCount(),
                "total" => $user_cart->formatPrice($user_cart->getItemsPriceRaw())
            ]
        );
    }

    /**
     * Adds a single item to the cart from POST
     */
    public function addItemToCart($params)
    {
        $cart = new ShoppingCarts($this->getEntityMgr());
        $item_data = new ItemData($this->getEntityMgr());
        $item = $item_data->getItem($_POST['type_code'], $_POST['item_id']);
        $response = [];
        $response['errors'] = [];
        $response['success'] = true;

        $sku_array = $item_data->getItemSkuArray($item, $this->getUser());

        if (is_null($item)) {
            $response['errors'][] = 'Unable to process request.';
        }

        // Check to make sure colors exist for this product and
        // that the the option selected exists in the color array
        $color_id = intval($_POST['color']);
        if (!is_null($sku_array['colors'])) {
            $color_exists = false;
            foreach ($sku_array['colors'] as $color) {
                if ($color_id === $color['id']) {
                    $color_exists = true;
                    break;
                }
            }
            if (!$color_exists) {
                $response['errors'][] = 'Please select a color.';
            }
        }

        // Check to make sure sizes exist for this product and
        // that the the option selected exists in the size array
        $size_id =  intval($_POST['size']);
        if (!is_null($sku_array['sizes'])) {
            $size_exists = false;
            foreach ($sku_array['sizes'] as $size) {
                if ($size_id === $size['size_id']) {
                    $size_exists = true;
                    break;
                }
            }
            if (!$size_exists) {
                $response['errors'][] = 'Please select a size.';
            }
        }

        $quantity = filter_input(INPUT_POST, "quantity", FILTER_SANITIZE_NUMBER_INT);
        $sku_quantity = filter_input(INPUT_POST, "sku_quantity", FILTER_SANITIZE_NUMBER_INT);

        if ($item->getIsLimitBySkuQuantity() && $quantity > $sku_quantity) {
            $response['errors'][] = 'Not enough stock.';
        }

        if (count($response['errors']) == 0) {
            $cartResponse = $cart->addItemToUsersShoppingCart(
                $this->getUser(),
                $item,
                filter_input(INPUT_POST, "quantity", FILTER_SANITIZE_NUMBER_INT) ?? 0,
                filter_input(INPUT_POST, "size", FILTER_SANITIZE_NUMBER_INT) ?? 0,
                filter_input(INPUT_POST, "color", FILTER_SANITIZE_NUMBER_INT) ?? 0,
                filter_input(INPUT_POST, "logo_id", FILTER_SANITIZE_NUMBER_INT) ?? 0,
                filter_input(INPUT_POST, "logo_location", FILTER_SANITIZE_NUMBER_INT) ?? 0
            );

            $response['items'] = $cartResponse->getShoppingCartItems();
            $response['count'] = $cartResponse->getItemsCount();
            $response['total'] = $cartResponse->formatPrice($cartResponse->getItemsPriceRaw());
        } else {
            $response['success'] = false;
        }

        if (isset($params['json'])) {
            return new JsonResponse($response);
        } else {
            return new RedirectResponse("/cart");
        }
    }
                                </code></pre></div>
                                </li>
                                <li>
                                    <div class="collapsible-header">PHP - Data Controller (between model and view) for a slideshow admin</div>
                                    <div class="collapsible-body"><pre><code class="php6">

namespace TwCore\Controllers\Data;

use Doctrine\Common\Collections\Criteria;
use TwCore\Model\HomeshowConfiguration;

/**
 * Class Homeshow
 * Handles database CRUD and data manipulation for
 * the Homeshow table.
 *
 * @package TwCore\Controllers\Data
 */
class Homeshow extends BaseData
{
    /**
     * @var string
     */
    private $entity = "HomeshowConfiguration";

    /**
     * Gets each homeshow record from the database and
     * renders the slide accordingly.
     *
     * @param bool $admin indicates whether the slides are
     * for the admin or the index. If for index, dates are
     * checked.
     *
     * @return array $slides
     */
    public function getHomeshowSlides($admin = false)
    {
        $criteria = new Criteria();

        if (!$admin) {
            $criteria->where($criteria->expr()->lte('start_date_mysql_ts', date("YmdHi")))
                ->andWhere($criteria->expr()->gte('end_date_mysql_ts', date("YmdHi")))
                ->orWhere($criteria->expr()->eq('start_date_mysql_ts', 0));
        }

        $criteria->orderBy(['order_by' => 'ASC']);
        $slide_collection = $this->getRepo($this->entity)->matching($criteria)->toArray();

        $slides = [];

        /**
         * @var HomeshowConfiguration $slide
         */
        foreach ($slide_collection as $slide) {
            $slide->setCaption(html_entity_decode($slide->getCaption()));
            $slides[] = $slide->toArray();
        }

        return $slides;
    }

    /**
     * Saves homeshow slides based on $_POST from
     * homeshow config admin. Sanitizes post then saves
     * data to the respective slide ID.
     *
     * @param array $slide_val_array - an associative array
     * representing a HomeShowConfiguration row.
     */
    public function saveHomeshowSlide(array $slide_val_array)
    {
        if (isset($slide_val_array['id']) && !empty($slide_val_array['id']) && is_numeric($slide_val_array['id'])) {
            $entity = $this->getRepo($this->entity)->find($slide_val_array["id"]);
            $entity->fromArray($slide_val_array);
            $this->getEntityMgr()->merge($entity);
        }

        $this->getEntityMgr()->flush();
    }

    /**
     * Creates a new slide and loads the blank / new
     * form.
     *
     * @return array $slide
     */
    public function renderNewSlide()
    {
        $slide = new HomeshowConfiguration();
        $this->getEntityMgr()->persist($slide);
        $this->getEntityMgr()->flush();
        return $slide->toArray();
    }

    /**
     * Takes an array of arrays with parameters
     * ID and Order, updates each slide with
     * respective order.
     *
     * @param array $slide_array
     */
    public function updateSlideshowOrder(array $slide_array)
    {
        foreach ($slide_array as $slide) {
            $entity = $this->getRepo($this->entity)->find($slide["id"]);
            $entity->setOrderBy($slide["order"]);
            $this->getEntityMgr()->merge($entity);
        }

        $this->getEntityMgr()->flush();
    }

    /**
     * Deletes a slide by ID
     *
     * @param int $id the ID of the slide to delete
     * @throws \Exception if not numeric
     */
    public function deleteSlide($id)
    {
        if (filter_var($id, FILTER_VALIDATE_INT)) {
            $entity = $this->getRepo($this->entity)->find($id);
            $this->getEntityMgr()->remove($entity);
            $this->getEntityMgr()->flush();
        } else {
            throw new \Exception("ID must be numeric.");
        }
    }
}
                                </code></pre></div>
                                </li>
                                <li>
                                    <div class="collapsible-header">Javascript &bull; Ajax &bull; Jquery - eCommerce item page JS</div>
                                    <div class="collapsible-body">
                                        <strong>Note: I removed just a little of the code in here because it had some HTML tags in it and my IDE just had a meltdown.
                                        </strong><pre><code class="javascript">

// variables that are used prolifically and should
// be cached.
var logo = "";
var color = "";
var base_img_url = "";
var item_img_url = "";
var active_img = "";
var active_update = 0;
var product_img = {};
var product_price = {};
var option_denial = {};
var init_price = 0;

var contains = function (needle) {
    // Per spec, the way to identify NaN is that it is not equal to itself
    var findNaN = needle !== needle;
    var indexOf;

    if (!findNaN && typeof Array.prototype.indexOf === 'function') {
        indexOf = Array.prototype.indexOf;
    } else {
        indexOf = function (needle) {
            var i = -1, index = -1;

            for (i = 0; i < this.length; i++) {
                var item = this[i];

                if ((findNaN && item !== item) || item === needle) {
                    index = i;
                    break;
                }
            }

            return index;
        };
    }

    return indexOf.call(this, needle) > -1;
};

// Document Ready function fires on page load
$(document).ready(function () {

    // cache base img url, typically //sirv url/item_images/sku
    // is used to update the image based on user selection.
    base_img_url = $('#base_img_url').val();
    item_img_url = $('#item_img_url').val();

    active_img = $('#initial_img').val();
    active_update = parseInt($('#update_initial').val());

    // cache the product img DOM object
    product_img = $("img.product_image");

    // set the initial image
    $(product_img).attr("src", base_img_url + ".jpg");

    // cache the price DOM object
    product_price = $('#price').find('span');

    // set the initial logo
    logo = $('#initial_logo').val();

    // set the initial color
    color = $('#initial_color').val();

    // set initial price
    init_price = parseFloat($(product_price).html());

    reloadImage();

    //get the option denial object to store
    var type_id = $('#item_id').val();
    var item_id = $('#type_code').val();
    getOptionDenial(type_id, item_id);
});

// Get the JSON denial object from the ItemData getOptionDenialArray
// function, parse it and store it as an object.
function getOptionDenial(type_id, item_id) {
    $.post("/get_option_denial_json", {item_id: item_id, item_type_code: type_id}, function (data) {
        option_denial = jQuery.parseJSON(data);
    });
}

/**
 * This function will validate the currently selected
 * size, color and logo against the cached option
 * denial json object.
 */
function validateOptionSelection() {
    // Reset the denial message HTML and the button
    $("#option_denial_message").html("");
    $("#addToCartBtn").removeClass('disabled');

    // Assign the currently selected values to variables
    var selected_color = $("select#color_selection").find("option:selected").data("slug");
    var selected_logo = $("select#logo_selection").find("option:selected").data('logo_id');
    var selected_size = $("select#size_selection").find("option:selected").data('size_id');

    var denied_sizes = [];
    var denied_colors = [];
    var denied_logos = [];

    // Iterate through the denial object
    $.each(option_denial, function (index, denial) {
        // Instantiate a variable to count the strikes.
        // If this reaches 3, the combination is denied.
        var strikes = 0;

        // If a value is empty, then it's an immediate strike.
        // IE if the option denial is, deny fresh pink in logo 1,
        // then it is assumed all sizes are also denied for fresh pink logo 1.
        // Otherwise, check if the selected value matches the denied value
        // and add a strike if so.
        if (denial.color === "") {
            strikes++;
        } else {
            if (denial.color === selected_color) {
                strikes++;

                if (denial.logo !== "") {
                    if (!contains.call(denied_logos, denial.logo)) {
                        denied_logos.push(denial.logo);
                    }
                }

                if (denial.size !== "") {
                    if (!contains.call(denied_sizes, denial.size)) {
                        denied_sizes.push(denial.size);
                    }
                }
            }
        }

        if (denial.logo === "") {
            strikes++;
        } else {
            if (denial.logo === selected_logo) {
                strikes++;

                if (denial.color !== "") {
                    if (!contains.call(denied_colors, denial.color)) {
                        denied_colors.push(denial.color);
                    }
                }

                if (denial.size !== "") {
                    if (!contains.call(denied_sizes, denial.size)) {
                        denied_sizes.push(denial.size);
                    }
                }
            }
        }

        if (denial.size === "") {
            strikes++;
        } else {
            if (denial.size === selected_size) {
                strikes++;

                if (denial.color !== "") {
                    if (!contains.call(denied_colors, denial.color)) {
                        denied_colors.push(denial.color);
                    }
                }

                if (denial.logo !== "") {
                    if (!contains.call(denied_logos, denial.logo)) {
                        denied_logos.push(denial.logo);
                    }
                }
            }
        }

        // If strikes are greater than or equal to 3, the combination is denied.
        // We have to consider colors, logos and sizes. This whole baseball
        // analogy I have going on is entirely coincidental.
        if (strikes >= 3) {
            $("#option_denial_message").html(denial.message + "<br><br>");
            $("#addToCartBtn").addClass('disabled');
        }
    });

    //Reset all the things.
    $('#size_selection').find('option').each(function () {
        if (!contains.call(denied_sizes, $(this).data('size_id'))) {
            $(this).prop("disabled", false);
        }
    });

    $('#color_selection').find('option').each(function () {
        if (!contains.call(denied_colors, $(this).data('slug'))) {
            $(this).prop("disabled", false);
        }
    });

    $('#logo_selection').find('option').each(function () {
        if (!contains.call(denied_logos, $(this).data('logo_id'))) {
            $(this).prop("disabled", false);
        }
    });

    $.each(denied_sizes, function (index, size) {
        $("#size_option_" + size).prop("disabled", true);
    });

    $.each(denied_colors, function (index, color) {
        $("#color_option_" + color).prop("disabled", true);
        ;
    });

    $.each(denied_logos, function (index, logo) {
        $("#logo_input_" + logo).prop("disabled", true);
    });
}

/**
 * Update the size selection and highlight
 * the currently selected size, after making
 * sure all previously selected sizes are no
 * longer highlighted. Update the corresponding
 * price.

 */
function updateSize() {

    updatePrice();
    validateOptionSelection();
}


function updatePrice() {
    var quantity_el = $("#item_quantity");
    var status_div = $("#sku_quantity_status");

    var value = $(quantity_el).val();

    if (!$.isNumeric(value) || value < 1) {
        $(quantity_el).val(1);
    }

    $(status_div).removeClass("red-text");
    $("#addToCartBtn").removeClass("disabled");

    var size_selection = $("#size_selection");
    var quantity = parseInt($(quantity_el).val());
    var size_price = $(size_selection).find("option:selected").data('price');
    var sku_quantity = $(size_selection).find("option:selected").data('sku_quantity');

    if(!sku_quantity) {
        sku_quantity = $("input#sku_quantity").val();
    } else {
        $("input#sku_quantity").val(sku_quantity);
    }

    if(parseInt($("#is_limit_by_sku_quantity").val()) > 0 ) {

        $(status_div).html(sku_quantity + " available");

        if(parseInt(quantity) > parseInt(sku_quantity)) {
            $(status_div).addClass("red-text");
            $("#addToCartBtn").addClass("disabled");
            $(".sku_quantity_error").html(" | Please lower quantity.");
        }
    }

    var price = 0;


    if (size_price === undefined) {
        price = init_price * quantity;
    } else {
        price = size_price * quantity;
    }

    $("input#item_price").val(price);

    // fancy reload
    $(product_price).fadeOut(200, function () {
        // set the new price
        $(product_price).html(price.toFixed(2));
    }).fadeIn(200);
}

/**
 * Update the global color variable for use in
 * image reloading and highlight the currently
 * selected color while making sure previously
 * selected colors are no longer highlighted.
 * Reload the image.
 *
 */
function updateColor(el) {
    color = $(el).find("option:selected").data("slug");
    $("input#color_name").val($(el).find("option:selected").data("color_name"));
    reloadImage();
    validateOptionSelection();
}

/**
 * Update the global logo variable and reload
 * the image.
 *
 * @param el
 */
function update_logo(el) {
    logo = $(el).find("option#logo_input_" + $(el).val()).data('name');
    reloadImage();
    validateOptionSelection();
}

/**
 * Sets the SRC attribute of the product image
 * to match the current selections. Called
 * whenever the global color or logo variables
 * are updated.
 */
function reloadImage() {
    // grab the base url
    var url = item_img_url + active_img;

    if (color !== "") {
        // if there's a color, append that to the base url
        url = url + '-' + color;

        // if there is a color and a logo, append logo to base url
        if (logo !== "") {
            url = url + '-' + logo;
        }
    }

    // add the extension
    url = url + '.jpg';
    // Main image will only update if image is an updateable
    // image
    if(active_update === 1) {
        $(product_img).fadeTo(250, 0.00, function () {
            // set the new source
            $(product_img).attr('src', url);
        }).delay(300).fadeTo(250, 1);
    }

    reloadGalleryImages();
}

function reloadGalleryImages() {

    $("#product_img_gallery").find("img").each(function(){

        var url = item_img_url + $(this).data("base_name");
        var img = this;
        if (color !== "") {
            // if there's a color, append that to the base url
            url = url + '-' + color;

            // if there is a color and a logo, append logo to base url
            if (logo !== "") {
                url = url + '-' + logo;
            }
        }

        url = url + '.jpg';

        if(parseInt($(this).data("update")) === 1) {
            $(img).attr("src", url);
        }
    });
}

/** swaps the main image for the one passed **/
function swapProductImage(el) {
    var url = $(el).attr("src");
    active_img = $(el).data("base_name");
    active_update = parseInt($(el).data("update"));

    $("#product_img_gallery").find("img").each(function () {
        $(this).css("opacity", "0.8");
    });

    $(el).css("opacity", "1");

    // fancy reload
    $(product_img).fadeTo(250, 0.00, function () {
        // set the new source
        $(product_img).attr('src', url);
    }).delay(300).fadeTo(250, 1);
}

//** displays the image preview modal **/
function imgPreview() {
    $("#productImgLarge").modal("open");
}
/**
 * Updates the price displayed under the
 * bulk entry inputs
 */
function updateBulkPrice() {
    var price = 0;
    var disabled = false;

    $("#addBulkToCartBtn").removeClass("disabled");
    $(".sku_quantity_error").html("");

    $("td.bulk_input_col").each(function () {
        var unique_id = $(this).data("unique_id");
        var quantity = $(this).data("sku_quantity");
        var qty_input = $("#bulk_input_" + unique_id);
        var value = $(qty_input).val();

        if (!$.isNumeric(value) || value < 0) {
            $(qty_input).val(0);
            value = 0;
        }

        if (value > 0) {
            var qty = parseFloat(value);
            var input_price = parseFloat($("#bulk_input_price_" + unique_id).val());
            var col_price = qty * input_price;
            price = price + col_price;
        }

        if (parseInt(value) > parseInt(quantity)) {
            disabled = true;
        }
    });

    if (disabled && parseInt($("#is_limit_by_sku_quantity").val()) > 0) {
        $("#addBulkToCartBtn").addClass("disabled");
        $(".sku_quantity_error").html("Not enough stock for quantity selection. <br><br>");
    }

    $("span.bulk_input_total").html(price.toFixed(2));
}

function addToCart(form) {
    var params = $(form).serialize();
    $("#addToCartBtn").html("<i class='fa fa-refresh fa-spin'></i>");
    $("#error_msg").html("");

    $.ajax({
        type: "POST",
        url: "/item/add_item_to_cart_json/1",
        data: params,
        dataType: "json"
    }).done(function (response) {
        if (response.success) {
            $(".cart-update-quantity").html(response.count);
            $(".cart-update-subtotal").html(response.total);
            $("#shack_header_cart").slideDown("fast");
            $("#addToCartBtn").html("Success!");
            $("html, body").animate({scrollTop: 0}, "slow");
            setTimeout(function () {
                $("#addToCartBtn").html("Add To Cart");
            }, 1000);
        } else {
            $("#addToCartBtn").html("Add To Cart");
        }
}
                                </code></pre></div>
                                </li>
                            </ul>
                            <br>
                            <p>
                                This should give you a good idea of my skills! If you have any concerns or there's something I didn't cover or you
                                want to give me a challenge and have me write up a quick script for you, just shoot me an email!
                            </p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </main>
    <script src="js/design.js"></script>
@endsection