<?php

$stylesheet = "    .wrapper {
        max-width: 90%!important;
    }

    li {
        list-style: none;
        margin: 0;
        padding: 0;
        font-weight: inherit;
        font-size: inherit;
    }
    
    ul {
        margin: 0;
        padding: 0;
        font-weight: inherit;
        font-size: inherit;
        margin-block-start: 0;
        margin-block-end: 0;
    }
    
    .sidebar {
        width: 220px;
        height: 100%;
        position: relative;
        background: #fff;
        box-shadow: inset -1px 0 0 0 #e3e8ee;
        z-index: 3;
    }
    
    .sidebar-header {
        height: 80px;
        width: 220px;
        z-index: 5;
    }
    
    .sidebar-nav {
        top: 80px;
        bottom: 52px;
        -webkit-overflow-scrolling: touch;
        overflow-x: auto;
        width: 100%;
        padding-top: 12px;
    }
    
    .sidebar-nav-items {
        padding: 0;
        padding-bottom: 10px;
    }
    
    .sidebar-nav-item {
        display: block;
        margin: 0;
        margin-top: 2px;
        padding: 4px 16px;
        font-weight: 500;
        font-size: 14px;
        line-height: 20px;
        cursor: pointer;
        text-decoration: none;
        color: #333;
    }
    
    .sidebar-nav-item:active, .sidebar-nav-item:focus, .sidebar-nav-item:hover {
        color: #7f8fa2 !important;
    }
    
    a, a:link {
        color: #333 !important;
    }
    
    a, a:hover {
        text-decoration: none;
        outline: 0;
        cursor: pointer;
    }

    .content {
        top: 0;
        left: 220px;
        bottom: 0;
        right: 0;
        box-sizing: border-box;
        -webkit-overflow-scrolling: touch;
        background: #fff;
        outline: none!important;
        overflow-x: hidden;
    }
    
    .method {
        width: 100%;
        align-items: center;
        background: #fff;
    }
    
    .method-doc {
        width: 35vw;
        max-width: 600px;
        margin-right: 5vw;
        flex-shrink: 0;
    }
    
    .method-title {
        display: flex;
        flex-direction: row;
        align-items: flex-start;
        justify-content: space-between;
    }
    
    .method-example {
        padding-top: 60px;
        flex-grow: 1;
        position: sticky;
        align-self: flex-start;
        top: 0;
    }
    
    .method-area {
        display: flex;
        flex-direction: row;
        padding: 3vw;
    }
    
     .method-example-request {
        border-radius: 8px;
        background: #7f8fa2;
    }
    
    .method-example-request-topbar {
        background: #485564;
        padding: 4px;
        border-top-right-radius: 8px;
        border-top-left-radius: 8px;
    }
    
    .method-example-request-title {
        color: #cbcbcb;
        padding: 8px;
        padding-left: 12px;
    }
    
    pre {
        padding: 12px 20px;
        margin: 0;
    }
    
    code {
        color: #fff;
    }
    
    badge {
        padding: 4px;
        color: white;
        background: black;
        border-radius: 10px;
    }
	
	badge.get {
        background: green!important;
    }
    
    badge.put {
        background: blue!important;
    }
	
	.params {
		width: 100%;
		padding-bottom: 8px;
		padding-top: 3px;
		margin-bottom: 2px;
		border-bottom: 1px solid #dddddd;
		font-weight: bold;
		display: inline-flex;
		flex-direction: row;
		flex-wrap: nowrap;
		align-items: center;
	}
	
	.description {
		display: inline-block;
		text-align: end;
		flex: 1;
	}
	
	.params span {
		padding-left: 10px;
	}";
