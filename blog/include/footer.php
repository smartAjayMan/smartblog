<?php include(ROOT_PATH.'/blog/connect/db.php'); ?>
<footer class="footer bc-gray">
        <div class="flexible flex-coloum">
            <ul class="content footer-most">
               
                <?php
                  $sql = "SELECT topic_id, topics_name, description FROM topics ORDER BY RAND() LIMIT 3";
                  $stmt = $conn->prepare($sql);
                  $stmt->execute();
                  $result = $stmt->get_result();
                  while ($topics = mysqli_fetch_assoc($result)):
                
                ?>
                  <li class="content-img footer-many bc-greenlight"> 
                    <h3 class="cr-white"><?php echo $topics['topics_name'] ?></h3>
                    <a href="<?php echo (BASE_URL.'/channel/topics.php?topic_id='.$topics['topic_id']) ?>" class="topics-list cr-black">Lorem ipsum, dolor sit amet consectetur adipisicing elit. 
                       <?php echo html_entity_decode($topics['description']) ?>
                    </a>
                  </li>
                <?php endwhile; ?>
            </ul>
            <ul class="content">
                <li class="content-img footer-many bc-greenlight"> 
                    <h3 class="cr-white">About</h3>
                    <a href="#" class="topics-list cr-black">Lorem ipsum, dolor sit amet consectetur adipisicing elit. 
                        Debitis inventore facere est velit et beatae expedita, quidem architecto eligendi, minima ducimus iusto,
                         consequatur iure reprehenderit. Voluptas blanditiis officiis voluptates soluta.
                    </a>
                </li>
                <li class="content-img footer-many bc-greenlight"> 
                    <h3>www.tutorial.com</h3>
                    <div>
                        www.tutorial.com &copy; reserved content
                    </div>
                </li>
                <li class="content-img footer-many bc-greenlight"> 
                          <h3 class="t-c">Contacts Us</h3>
                    <div>
                        <form action="#" class="flexible coloums bc-white form-c" autocomplete="off">
                            <label for="fullname" class="form-lable">Full Name</label>
                            <input class="form-input" type="text" id="fullname" required>
                            <label for="email" class="form-lable">Email</label>
                            <input class="form-input" type="email" id="email" required>
                            <label for="desc" class="form-lable">Description</label>
                            <textarea class="form-input form-body" name="desc" id="desc" cols="30" rows="2" required ></textarea>
                            <button type="submit" class="form-button form-lable">Send</button>
                        </form>
                    </div>
                </li>
            </ul>
        </div>
        <div class="change-text cr-white">
      
          <ul class="change-text flexible">
              <li class="list-style"><a href="#">Terms & Conditions</a></li>
          </ul>
          www.tutorial.com &copy; reserved content
        </div>
    </footer>