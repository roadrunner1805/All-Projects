# Question 1
myDF <- read.csv("/anvil/projects/tdm/data/movies_and_tv/rotten_tomatoes_movies.csv")
head(myDF)
myDF <- myDF[ , !names(myDF) %in% c("cast", "movie_info")]
