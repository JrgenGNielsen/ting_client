import unittest
import logging
import os
from selenium import webdriver
from selenium.webdriver.common.keys import Keys

build_url = os.getenv('FEATURE_BUILD_URL', '')
print 'Selenium test URL: ', build_url

driver = webdriver.PhantomJS()
driver.get(build_url)
assert "Site-Install" in driver.title

driver.close()
