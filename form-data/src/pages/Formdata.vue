<!--
 * @Description: 
 * @Author: jinxiaojian
 * @Email: jinxiaojian@youxin.com
 * @Date: 2019-11-22 15:36:52
 * @LastEditTime : 2020-01-15 14:11:58
 * @LastEditors  : 靳肖健
 -->
<template>
  <el-container style="max-width:100vw;min-height:100vh">
    <el-header
      style="height:5vw;line-height:5vw;background:#1f2d3d;display:flex;justify-content: space-between;align-items:center"
    >
      <div>
        <h1 style="font-size:2vw;color:rgb(183, 195, 210)">formData辅助模板系统</h1>
      </div>
      <div style="height:40px">
        <div v-if="!logined">
          <el-form :inline="true" :model="formLogin" class="demo-form-inline">
            <el-form-item label>
              <el-input v-model="formLogin.user" placeholder="用户名"></el-input>
            </el-form-item>
            <el-form-item label>
              <el-input type="password" v-model="formLogin.password" placeholder="密码"></el-input>
            </el-form-item>
            <el-form-item>
              <el-button type="primary" @click="login_user">{{btnText}}</el-button>
            </el-form-item>
          </el-form>
        </div>
      </div>
    </el-header>
    <el-container>
      <div style="width:100%">
        <el-tabs style="padding:1vw" v-model="activeName" @tab-click="handleClick">
          <el-tab-pane label="静态模板" name="jtmb">静态模板</el-tab-pane>
          <el-tab-pane label="HfqDataEle模板" name="elemb">HfqDataEle模板</el-tab-pane>
          <el-tab-pane label="HfqDataFrom模板" name="arrmb">HfqDataEle连写模板</el-tab-pane>
        </el-tabs>
        <el-container v-if="activeName=='jtmb'">
          <el-header style="min-height:5vw;height:auto">
            <DataSelect :dataArr="dataArr" @textareaChange="textareaChange" />
          </el-header>
          <el-main>
            <DataArea :textarea="textarea" :logined="logined" />
          </el-main>
        </el-container>
        <el-container v-else-if="activeName=='elemb'">
          <DataEle type="elemb" :logined="logined" />
        </el-container>
        <el-container v-else-if="activeName=='arrmb'">
          <DataEle type="arrmb" :logined="logined" />
        </el-container>
      </div>
    </el-container>
  </el-container>
</template>

<script>
import DataArea from "../components/DataArea";
import DataSelect from "../components/DataSelect";
import DataEle from "../components/DataEle";
// import dataArr from "../assets/data.js";
import ajax from "../assets/ajax.js";

export default {
  name: "Formdata",
  components: {
    DataArea,
    DataSelect,
    DataEle,
  },
  props: {
    msg: String,
  },
  data() {
    return {
      dataArr: [],
      logined: 0,
      btnText: "登录",
      formLogin: {
        user: "",
        password: "",
      },
      showDialog: 0,
      textarea: "",
      activeName: "jtmb",
    };
  },
  created() {
    this.start();
  },
  methods: {
    start() {},
    initList() {
      ajax({
        that: this,
        url: `/content.php`,
        success: data => {
          this.dataArr = data.content;
        },
      });
    },
    login_user() {
      ajax({
        that: this,
        url: `/login.php?u=${this.formLogin.user}&p=${this.formLogin.password}`,
        success: () => {
          this.logined = 1;
          this.initList();
        },
        error: () => {
          this.logined = 0;
          this.btnText = "登录失败";
          setTimeout(() => {
            this.btnText = "登录";
          }, 1000);
        },
      });
    },
    handleClick(tab, event) {
      console.log(tab, event);
    },
    textareaChange(val) {
      this.textarea = val;
    },
  },
};
</script>
<style>
</style>
