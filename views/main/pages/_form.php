<style>
	
  .discord-login{
  	border-radius: 4px; 
    
    
    display: inline-block;
    font-weight: normal;
    line-height: 1.25;
    text-align: center;
    white-space: nowrap;
    vertical-align: middle;
    user-select: none;
    font-size: 0.9rem;
    border-width: 1px;
    cursor: pointer;
    border-style: solid;
    border-image: initial;
    padding: 0.5rem 1rem;
    padding-left: 1.25em;
    padding-right: 1.25em;
    transition: all 0.2s;
        color: rgb(255, 255, 255);
    background-color: #7289DA;
    border-color: #7289DA;

  }

  .discord-login:hover,.discord-login:active{
  	    color: rgb(255, 255, 255);
    background-color: #3C45A5;
    border-color: #3C45A5;
    cursor: pointer;
    text-decoration: none;
  }

</style>
<p>
	<a  class ="discord-login" href="<?=site_url('extensions/nova_ext_discord_account_confirmation/Discord/login')?>"><i class="fab fa-discord"></i> <span>Login with Discord</span> </a>
	
</p>