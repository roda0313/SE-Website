CREATE TABLE Users(
	USERNAME TEXT PRIMARY KEY NOT NULL,
	PASSWORD TEXT NOT NULL,
	FIRSTNAME TEXT,
	LASTNAME TEXT,
	EMAIL TEXT,
	DATECREATED DATE,
	LASTMODIFIED DATE,
	LASTVISIT DATE,
	NEWSFEEDS TEXT DEFAULT "",
	PERMISSIONS INT
);

CREATE TRIGGER date_created AFTER INSERT ON Users
BEGIN
	UPDATE Users SET DATECREATED = Datetime('now') WHERE ROWID = NEW.ROWID;
END;

CREATE TRIGGER date_modified AFTER UPDATE ON Users
BEGIN
	UPDATE Users SET LASTMODIFIED = Datetime('now') WHERE ROWID = NEW.ROWID;
END;

CREATE TABLE NewsFeed (
	ID INTEGER PRIMARY KEY,
	NAME TEXT NOT NULL,
	LINK TEXT NOT NULL
);

INSERT INTO NewsFeed (NAME, LINK) VALUES ("BBC News", "https://feeds.bbci.co.uk/news/rss.xml?edition=us");
INSERT INTO NewsFeed (NAME, LINK) VALUES ("Google News", "https://news.google.com/news?cf=all&hl=en&pz=1&ned=us&topic=w&output=rss");
INSERT INTO NewsFeed (NAME, LINK) VALUES ("CNN", "http://rss.cnn.com/rss/cnn_topstories.rss");
INSERT INTO NewsFeed (NAME, LINK) VALUES ("Al Jazeera", "http://www.aljazeera.com/xml/rss/all.xml");
INSERT INTO NewsFeed (NAME, LINK) VALUES ("NBC News", "http://feeds.nbcnews.com/feeds/topstories");


