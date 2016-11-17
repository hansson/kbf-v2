package se.karlskronabergsport.rest;

import javax.ws.rs.GET;
import javax.ws.rs.Path;
import javax.ws.rs.PathParam;
import javax.ws.rs.Produces;
import javax.ws.rs.core.MediaType;

import se.karlskronabergsport.entity.Person;

@Path("person")
public class PersonService {

	@GET
	@Produces(MediaType.APPLICATION_JSON)
	@Path("{socSec}")
	public Person getPerson(@PathParam(value = "socSec") String socSec) {
		System.out.println(socSec);
		return new Person("9011031979", "Tobias", "Hansson");
	}
}
