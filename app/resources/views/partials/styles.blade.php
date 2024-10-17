<style>
    body {
        background-color: #f8f9fa;
        margin: 20px;
    }
    .container {
        margin-top: 50px;
    }
    .card {
        margin-bottom: 20px;
    }
    .card h5 {
        color: #007bff;
    }

    .articles {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
    }

    .article-tile {
        border: 1px solid #ccc;
        padding: 16px;
        width: calc(50% - 20px);
        box-sizing: border-box;
        cursor: pointer;
        transition: background-color 0.3s, border-color 0.3s;
    }

    .article-tile:hover {
        background-color: #f0f0f0;
    }

    .article-tile.selected {
        background-color: #d0e6f8;
        border-color: #4a90e2;
    }

    .pagination {
        margin-top: 20px;
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 10px;
    }

    .pagination button {
        padding: 10px 20px;
        cursor: pointer;
    }
</style>