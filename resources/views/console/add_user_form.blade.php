<div class="container-fluid">
    <div class="row align-items-center justify-content-center" style="margin-top: 18px">
      
            <form method="POST" action="console/addUser" id ="add_user_form">
            <input type = "hidden" id = "scrollDash" name = "scrollDash">
                @csrf
              
                <div class="form-group">
                    <label for="username">新用户名</label>
                    <input
                        type="text"
                        class="form-control"
                        id="add_user_name"
                        aria-describedby="name"
                        placeholder="输入用户名"
                        name="name"
                    />
                </div>
                <div id="warn_no_username" style="display:none; color:red">用户名不能为空</div>
                <div id="warn_not_unique" style="display:none; color:red">用户名已被其他用户使用</div>
                <div class="form-group">
                    <label for="password">密码</label>
                    <input
                        type="text"
                        class="form-control"
                        id="add_pass_word"
                        placeholder="密码"
                        name="password"
                    />
                </div>
                 <div id="warn_no_password" style="display:none; color:red">密码不能为空</div>
               
            </form>
           
   
    </div>
   <div style="display: flex; justify-content: flex-end;">
    <button id="add_user_btn" type="submit" class="btn btn-primary">添加</button>
</div>
</div>
