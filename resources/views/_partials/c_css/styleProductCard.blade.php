<style>
    .product-grid {
        font-family: 'Poppins', sans-serif;
        text-align: center;
    }

    .product-grid .product-image {
        overflow: hidden;
        position: relative;
    }

    .product-grid .product-image a.image {
        display: block;
    }

    .product-grid .product-image img {
        width: 100%;
        height: auto;
        transition: all 0.5s ease 0s;
    }

    .product-grid:hover .product-image img {
        transform: scale(1.1);
    }

    .product-grid .product-links {
        background: #fff;
        width: 150px;
        padding: 10px 20px;
        margin: 0;
        list-style: none;
        border-radius: 30px;
        box-shadow: 1px 0 30px rgba(0, 0, 0, 0.3);
        opacity: 0;
        transform: translateX(-50%) translateY(-150%);
        position: absolute;
        top: 50%;
        left: 50%;
        transition: all .35s ease;
    }

    .product-grid:hover .product-links {
        opacity: 1;
        transform: translateX(-50%) translateY(-50%);
    }

    .product-grid .product-links li {
        width: 48%;
        margin: 10px 0;
        display: inline-block;
    }

    .product-grid .product-links li a {
        color: #788090;
        font-size: 18px;
        transition: all .3s;
    }

    .product-grid .product-links li a:hover {
        color: #341f97;
        text-shadow: 4px 4px 0 rgba(0, 0, 0, 0.2);
    }

    .product-grid .product-content {
        padding: 15px;
    }

    .product-grid .price {
        color: #333;
        font-size: 15px;
        font-weight: 500;
        margin: 0 0 10px;
    }

    .product-grid .price span {
        color: #999;
        font-weight: 400;
        margin: 0 0 0 5px;
        text-decoration: line-through;
    }

    .product-grid .title {
        font-size: 15px;
        font-weight: 500;
        text-transform: capitalize;
        margin: 0 0 12px;
    }

    .product-grid .title a {
        color: #333;
        transition: all 0.3s ease 0s;
    }

    .product-grid .title a:hover {
        color: #341f97;
        text-decoration: underline;
    }
    @media screen and (max-width: 990px) {
        .product-grid {
            margin-bottom: 30px;
        }
    }

</style>
